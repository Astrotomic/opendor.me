<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table(User::table(), static function (Blueprint $table): void {
            $table->timestamp('registered_at')->nullable();
        });

        User::query()
            ->whereHasGithubAccessToken()
            ->whereNotNull('email_verified_at')
            ->eachById(static function (User $user): void {
                $user->update([
                    'registered_at' => $user->email_verified_at,
                ]);
            });
    }

    public function down(): void
    {
        Schema::table(User::table(), static function (Blueprint $table): void {
            $table->dropColumn('registered_at');
        });
    }
};
