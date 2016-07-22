<?php

namespace Algorit\Addressing\Services;

use SimpleXMLElement;

class CepLivre extends AddressTransport
{
    /**
     * The service URL.
     *
     * @var string
     */
    protected $url = 'http://ceplivre.com.br/consultar/cep/f7b95ddf1cfc76fcebad3972ac3ddca6/%s/xml';

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
        $data = (new SimpleXMLElement($response->getBody()))->cep;

        return [
            'postalcode' => postalcode_to_int(object_get($data, 'cep')),
            'street'     => object_get($data, 'tp_logradouro').' '.object_get($data, 'logradouro'),
            'district'   => current(object_get($data, 'bairro')),
            'city'       => current(object_get($data, 'cidade')),
            'state'      => current(object_get($data, 'uf_sigla')),
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
