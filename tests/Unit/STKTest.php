<?php

namespace SmoDav\Mpesa\Tests\Unit;

use SmoDav\Mpesa\Tests\TestCase;
use SmoDav\Mpesa\C2B\STK;

class STKTest extends TestCase
{
    /**
     * Test that amount is set.
     *
     * @test
     **/
    public function testAmountShouldBeSet()
    {
        $stk = new STK($this->engine);
        $that = $stk->request(5000);
        $this->assertInstanceOf(STK::class, $that);
    }

    /**
     * Test that exception is trhrown when invalid amount is set.
     *
     * @test
     **/
    public function testItShouldThrowExceptionWithInvalidRequestAmount()
    {
        $this->expectException(\InvalidArgumentException::class);
        $stk = new STK($this->engine);
        $stk->request('Ksh 1000');
    }

    /**
     * Test failure when an invalid phone number is provided.
     *
     * @test
     **/
    public function testItShouldThrowExceptionWithInvalidNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        $stk = new STK($this->engine);
        $stk->from('0722xxxxxx');
    }

    /**
     * Test that a valid number is set.
     *
     * @test
     **/
    public function testThatAValidNumberIsSet()
    {
        $stk = new STK($this->engine);
        $that = $stk->from('254712345678');
        $this->assertInstanceOf(STK::class, $that);
    }

    /**
     * Test setting of reference number and description.
     *
     * @test
     **/
    public function testItShouldSetReference()
    {
        $reg = new STK($this->engine);
        $that = $reg->usingReference('LXD3434A', 'Demo Test Payment');
        $this->assertInstanceOf(STK::class, $that);
    }

    /**
     * Test failure when an invalid refernce number is provided.
     *
     * @test
     **/
    public function testItShouldThrowExceptionWithInvalidRefence()
    {
        $this->expectException(\InvalidArgumentException::class);
        $stk = new STK($this->engine);
        $stk->usingReference('FOO##123', 'Invalid Reference');
    }

    /**
     * Test STK push.
     *
     * @test
     **/
    public function testStkPush()
    {
        $stk = new STK($this->engine);
        $response = (array) $stk->request(1000)->from(254708374149)->usingReference('LX123TXN', 'Demo Payment')->push();
        $this->assertArrayHasKey('ConversationID', $response);
    }
}
