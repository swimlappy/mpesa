<?php

namespace SmoDav\Mpesa\Tests\Unit;

use SmoDav\Mpesa\Tests\TestCase;
use SmoDav\Mpesa\C2B\Registrar;

class RegistrarTest extends TestCase
{
    /**
     * Test for identity validation.
     *
     * @test
     **/
    public function testRegistrationProcess()
    {
        $reg = new Registrar($this->engine);
        $response = $reg->submit(1234, 'https://confirm.example.com', 'https://validation.example.com', 'Completed');
        $this->assertInstanceOf('stdClass', $response);
    }

    /**
     * Test failure with invalid validation URL.
     *
     * @test
     **/
    public function testItShouldThrowExceptionWithInvalidValidationURL()
    {
        $this->expectException(\InvalidArgumentException::class);
        $reg = new Registrar($this->engine);
        $reg->onValidation('Inivalid URL');
    }

    /**
     * Test failure with invalid confirmation.
     *
     * @test
     **/
    public function testItShouldThrowExceptionWithInvalidConfirmationURL()
    {
        $this->expectException(\InvalidArgumentException::class);
        $reg = new Registrar($this->engine);
        $reg->onConfirmation('Inivalid URL');
    }

    /**
     * Test failure with invalid response type.
     *
     * @test
     **/
    public function testItShouldThrowExceptionWithInvalidResponseType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $reg = new Registrar($this->engine);
        $reg->onTimeout('Error');
    }

    /**
     * Test setting of response type.
     *
     * @test
     **/
    public function testItShouldSetResponseType()
    {
        $reg = new Registrar($this->engine);
        $that = $reg->onTimeout('Completed');
        $this->assertInstanceOf(Registrar::class, $that);
        $that = $reg->onTimeout('Cancelled');
        $this->assertInstanceOf(Registrar::class, $that);
    }

    /**
     * Test setting of validation and confirmation URL.
     *
     * @test
     **/
    public function testItShouldSetURLs()
    {
        $reg = new Registrar($this->engine);
        $that = $reg->onConfirmation('https://confirm.example.com');
        $this->assertInstanceOf(Registrar::class, $that);
        $that = $reg->onValidation('https://validate.example.com');
        $this->assertInstanceOf(Registrar::class, $that);
    }
}
