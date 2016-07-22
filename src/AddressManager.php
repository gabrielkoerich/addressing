<?php

namespace Algorit\Addressing;

use Algorit\ServiceManager\Manager;

class AddressManager extends Manager
{
    /**
     * The addressing services.
     *
     * @var array
     */
    protected $services = [
        Services\Correios::class,
        Services\ClaresLab::class,
        Services\CepLivre::class,
        Services\CorreioControl::class,
        //...
    ];

    /**
     * Get address by postalcode.
     *
     * @param  string $postalcode
     * @return array
     */
    public function getByPostalCode($postalcode)
    {
        return $this->execute(function ($service) use ($postalcode) {
            return $service->createRequest(compact('postalcode'))->getResponse();
        });
    }
}
