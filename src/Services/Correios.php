<?php

namespace Algorit\Addressing\Services;

class Correios extends AddressTransport
{
    /**
     * The service URL.
     *
     * @var string
     */
    protected $url = 'http://correiosapi.apphb.com/cep/%s';

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
            'street'   => array_get($data, 'tipoDeLogradouro').' '.array_get($data, 'logradouro'),
            'district' => array_get($data, 'bairro'),
            'city'     => array_get($data, 'cidade'),
            'state'    => array_get($data, 'estado'),
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
        return array_get($response, 'street') == '';
    }
}
