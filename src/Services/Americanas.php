<?php

namespace Algorit\Addressing\Services;

class Americanas extends AddressTransport
{
    /**
     * The service URL.
     *
     * @var string
     */
    protected $url = 'https://carrinho.americanas.com.br/CustomerWeb/postalcode/%s';

    /**
     * Parse the response.
     *
     * @param mixed $response
     */
    protected function parse($response)
    {
        return json_decode($response->getBody(), true);
    }

    /**
     * Check if response is valid.
     *
     * @param  mixed $response
     * @return bool
     */
    protected function isInvalid($response)
    {
        return array_get($response, 'address') == '';
    }
}
