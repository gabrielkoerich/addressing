<?php

namespace Algorit\Addressing\Services;

class CorreioControl extends AddressTransport
{
    /**
     * The service URL.
     *
     * @var string
     */
    protected $url = 'http://cep.correiocontrol.com.br/%s.json';

    /**
     * Parse the response.
     *
     * @param mixed $response
     */
    protected function parse($response)
    {
        $data = json_decode($response->getBody(), true);

        return [
            'postalcode' => array_get($data, 'cep'),
            'street'   => array_get($data, 'logradouro'),
            'district' => array_get($data, 'bairro'),
            'city'     => array_get($data, 'localidade'),
            'state'    => array_get($data, 'uf'),
        ];
    }

    /**
     * Check if response is valid.
     *
     * @param  mixed $response
     * @return bool
     */
    protected function isInvalid($response)
    {
        return false;
    }
}
