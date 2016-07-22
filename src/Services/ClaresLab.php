<?php

namespace Algorit\Addressing\Services;

class ClaresLab extends AddressTransport
{
    /**
     * The service URL.
     *
     * @var string
     */
    protected $url = 'http://clareslab.com.br/ws/cep/json/%s';

    /**
     * Format the postalcode before send the request.
     *
     * @param  int $postalcode
     * @return mixed
     */
    protected function format($postalcode)
    {
        return int_to_postalcode($postalcode);
    }

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
            'street'   => array_get($data, 'endereco'),
            'district' => array_get($data, 'bairro'),
            'city'     => array_get($data, 'cidade'),
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
        return array_get($response, 'endereco') == '';
    }
}
