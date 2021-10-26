<?php

use App\Enums\BlockReason;
use App\Jobs\GithubJob;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;
use function Tests\GithubJob\job;

it('deletes the job if the user is blocked', function () {
    $user = $this->user('Gummibeer');
    $user->block_reason = BlockReason::INAPPROPRIATE();
    $user->update();

    $job = githubJob(function () {}, $user);
    app(Dispatcher::class)->dispatchNow($job);

    expect($job->job->isDeleted())->toBeTrue();
});

it('blocks the user and marks them as deleted if a certain status code is returned in the response', function (int $status) {
    $user = $this->user('Gummibeer');

    $job = githubJob(function () use ($status) {
        throw new ClientException(
            'this test should throw',
            new \GuzzleHttp\Psr7\Request('get', ''),
            new \GuzzleHttp\Psr7\Response($status)
        );
    }, $user);

    expect(app(Dispatcher::class)->dispatchNow($job))->toBeNull();

    expect($user->refresh())
        ->isBlocked()->toBeTrue()
        ->block_reason->toBe(BlockReason::DELETED());
})->with([
    Response::HTTP_NOT_FOUND,
    Response::HTTP_FORBIDDEN,
]);

it('throws a client exception if the status code is not handled', function (int $status) {
    $job = githubJob(function () use ($status) {
        throw new ClientException(
            'this test should throw',
            new \GuzzleHttp\Psr7\Request('get', ''),
            new \GuzzleHttp\Psr7\Response($status)
        );
    }, $this->user('Gummibeer'));

    app(Dispatcher::class)->dispatchNow($job);
})
    ->throws(ClientException::class, 'this test should throw')
    ->with([500, 502, 400]);

it('releases the job if a Github rate limit is hit', function () {
    Carbon::setTestNow(now());

    $spy = Log::spy();

    $job = githubJob(function () {
        throw new ClientException(
            'this test should throw',
            new \GuzzleHttp\Psr7\Request('get', '/users/repos'),
            new \GuzzleHttp\Psr7\Response(Response::HTTP_FORBIDDEN, ['X-RateLimit-Reset' => now()->addHour()->getTimestamp()])
        );
    }, $this->user('Gummibeer'));

    expect(app(Dispatcher::class)->dispatchNow($job))->toBeFalse();
    expect($job->job->isReleased())->toBeTrue();

    $spy->shouldHaveReceived('info', fn($message) => $message === 'Hit GitHub rate-limit for [/users/repos] delay 59 minutes and 59 seconds from now');
});

function githubJob(Closure $run, User $entity): GithubJob
{
    return new class($run, $entity) extends GithubJob {
        public function __construct(private Closure $run, protected User $user)
        {
            parent::__construct();
        }

        protected function run(): void
        {
            Closure::bind($this->run, $this)();
        }
    };
}
