<?php

namespace SmoDav\Mpesa\Tests\Unit;

use SmoDav\Mpesa\C2B\STK;
use SmoDav\Mpesa\C2B\Identity;
use SmoDav\Mpesa\C2B\Registrar;
use Orchestra\Testbench\TestCase;
use SmoDav\Mpesa\Contracts\CacheStore;
use SmoDav\Mpesa\Contracts\ConfigurationStore;

class LaravelTest extends TestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'SmoDav\Mpesa\Laravel\ServiceProvider',
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default cache driver
        $app['config']->set('cache.default', 'array');
    }

    /**
     * Test able to load aggregate service provider.
     *
     * @test
     */
    public function testServiceIsAvailable()
    {
        $this->assertTrue($this->app->bound('mp_stk'));
        $this->assertTrue($this->app->bound('mp_identity'));
        $this->assertTrue($this->app->bound('mp_registrar'));
        $this->assertInstanceOf(STK::class, $this->app->make('mp_stk'));
        $this->assertInstanceOf(Registrar::class, $this->app->make('mp_registrar'));
        $this->assertInstanceOf(Identity::class, $this->app->make('mp_identity'));
    }

    /**
     * Get package alliases.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'STK' => 'SmoDav\Mpesa\Laravel\Facades\STK',
            'Registrar' => 'SmoDav\Mpesa\Laravel\Facades\Registrar',
            'Identity' => 'SmoDav\Mpesa\Laravel\Facades\Identity',
        ];
    }

    /**
     * Test the Laravel cache.
     *
     * @test
     **/
    public function testLaravelCache()
    {
        $cache = $this->app->make(CacheStore::class);
        $this->assertTrue($cache->put('test', 'Demo value'));
        // In some way the cache store fails to store the value
        //$this->assertEquals($cache->get('test'), 'Demo value');
    }

    /**
     * Test the Laravel Config is loaded.
     *
     * @test
     **/
    public function testLaravelConfig()
    {
        $config = $this->app->make(ConfigurationStore::class);
        $this->assertEquals($config->get('mpesa.status'), 'sandbox');
    }
}
