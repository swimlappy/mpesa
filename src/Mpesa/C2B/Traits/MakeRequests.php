<?php

namespace SmoDav\Mpesa\C2B\Traits;

trait MakeRequests
{
    /**
     * Initiate the request.
     *
     * @param array $body
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    private function makeRequest($body = [])
    {
        return $this->engine->client->request('POST', $this->endpoint, [
            'headers' => [
                'Authorization' => 'Bearer '.$this->engine->auth->authenticate(),
                'Content-Type' => 'application/json',
            ],
            'json' => $body,
        ]);
    }
}
