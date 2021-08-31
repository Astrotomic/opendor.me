<?php

namespace App\HttpClient;

class Factory extends \Illuminate\Http\Client\Factory
{
    public function github(): GithubPendingRequest
    {
        $request = new GithubPendingRequest($this);
        $request->stub($this->stubCallbacks);

        return $request;
    }
}
