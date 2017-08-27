<?php

namespace SmoDav\Mpesa\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase as PHPUnit;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use SmoDav\Mpesa\Auth\Authenticator;
use SmoDav\Mpesa\Engine\Core;
use SmoDav\Mpesa\Native\NativeCache;
use SmoDav\Mpesa\Native\NativeConfig;

class TestCase extends PHPUnit
{
    /**
     * Engine Core.
     *
     * @var Engine
     **/
    protected $engine;

    protected $config;

    protected $cache;

    /**
     * Set mocks.
     **/
    protected function setUp()
    {
        $mock = new MockHandler([
            new Response(202, [], json_encode(['access_token' => 'access', 'expires_in' => 3599])),
            new Response(200, [], '{
                                      "ConversationID": "AG_20170827_0000591c44cb99997dd3",
                                      "OriginatorCoversationID": "32508-297942-1",
                                      "ResponseDescription": "The service request has been accepted successfully."
                                    }'),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $this->config = new NativeConfig();
        $this->cache = new NativeCache($this->config);
        $engine = new Core($client, $this->config, $this->cache);
        $auth = new Authenticator($engine);
        $engine->setAuthenticator($auth);
        $this->engine = $engine;
    }

    /**
     * Clean up after tests.
     **/
    protected function tearDown()
    {
        $this->engine = null;
        $this->config = null;
        $this->cache = null;
        // Empty the cache
        $file = __DIR__.'/../cache/.mpc';
        if (is_file($file)) {
            unlink($file);
        }
    }
}
