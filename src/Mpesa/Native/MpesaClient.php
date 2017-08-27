<?php

namespace Smodav\Mpesa\Native;

use GuzzleHttp\Client;
use SmoDav\Mpesa\C2B\STK;
use SmoDav\Mpesa\C2B\Identity;
use SmoDav\Mpesa\Engine\Core;
use SmoDav\Mpesa\C2B\Registrar;
use SmoDav\Mpesa\Native\NativeCache;
use SmoDav\Mpesa\Native\NativeConfig;

class MpesaClient
{
    /**
     * Mpesa Core.
     *
     * @var Core
     **/
    protected $engine;

    public function __construct()
    {
        $config = new NativeConfig();
        $cache = new NativeCache($config);
        $this->engine = new Core(new Client(), $config, $cache);
    }

    /**
     * Expose the Registrar API.
     *
     * @return Registrar
     **/
    public function registrar()
    {
        return new Registrar($this->engine);
    }

    /**
     * Expose the STK API.
     *
     * @return STK
     **/
    public function stk()
    {
        return new STK($this->engine);
    }

    /**
     * Expose the Identity API.
     *
     * @return Identity
     **/
    public function identity()
    {
        return new Identity($this->engine);
    }
}
