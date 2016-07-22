<?php

use Illuminate\Container\Container;
use Algorit\Addressing\AddressManager;

class AddressingTest extends PHPUnit_Framework_TestCase
{
    public function testServices()
    {
        $manager = new AddressManager(new Container);

        $data = $manager->getByPostalCode(88025000);

        $this->assertTrue(is_array($data));
        $this->assertArrayHasKey('postalcode', $data);
        $this->assertArrayHasKey('street', $data);
        $this->assertArrayHasKey('district', $data);
        $this->assertArrayHasKey('city', $data);
        $this->assertArrayHasKey('state', $data);

        $this->assertEquals(88025000, array_get($data, 'postalcode'));
        $this->assertEquals('Rua Frei Caneca', array_get($data, 'street'));
        $this->assertEquals('Agronômica', array_get($data, 'district'));
        $this->assertEquals('Florianópolis', array_get($data, 'city'));
        $this->assertEquals('SC', array_get($data, 'state'));
    }
}
