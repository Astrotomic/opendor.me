<?php

namespace App\HttpClient;

use Illuminate\Http\Client\Factory as HttpFactory;

class Factory extends HttpFactory
{
    public function github(): GithubPendingRequest
    {
        $request = new GithubPendingRequest($this);
        $request->stub($this->stubCallbacks);

        return $request;
    }
}
