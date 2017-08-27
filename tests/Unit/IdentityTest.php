<?php

namespace SmoDav\Mpesa\Tests\Unit;

use SmoDav\Mpesa\Tests\TestCase;
use SmoDav\Mpesa\C2B\Identity;

class IdentityTest extends TestCase
{
    /**
     * Test for identity validation.
     *
     * @test
     **/
    public function testValidationOfIdentity()
    {
        $auth = new Identity($this->engine);
        $response = $auth->validate('254700000000');
        // We will assume the server returns a success respone
        $this->assertEquals('AG_20170827_0000591c44cb99997dd3', $response->ConversationID);
    }

    /**
     * Test failure with invalid number.
     *
     * @test
     **/
    public function testItShouldThrowExceptionWithInvalidNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        $auth = new Identity($this->engine);
        $auth->validate('Inivalid');
    }
}
