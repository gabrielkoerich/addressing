<?php

namespace Algorit\Addressing\Services;

use Exception;
use GuzzleHttp\Client;
use InvalidArgumentException;

abstract class AddressTransport
{
    /**
     * The http client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * The service URL.
     *
     * @var string
     */
    protected $url;

    /**
     * The request options.
     *
     * @var array
     */
    protected $options = [
        'headers' => [
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8,application/json',
        ],
    ];

    /**
     * The address response.
     *
     * @var array
     */
    protected $response;

    /**
     * Create a new instance.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Format the postalcode before send the request. Default is integer.
     *
     * @param  mixed $postalcode
     * @return mixed
     */
    protected function format($postalcode)
    {
        return postalcode_to_int($postalcode);
    }

    /**
     * Create a new request.
     *
     * @param array $data
     */
    public function createRequest($data = [])
    {
        if (is_null($this->url)) {
            throw new InvalidArgumentException('An url must be set.');
        }

        $postalcode = $this->format(array_get($data, 'postalcode'));

        $response = $this->client->get(sprintf($this->url, $postalcode), $this->options);

        return $this->setResponse($this->parse($response));
    }

    /**
     * Get the service URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the parsed response.
     *
     * @param mixed
     */
    public function setResponse($response)
    {
        if ($this->isInvalid($response)) {
            throw new Exception('Address not found');
        }

        $this->response = $response;

        return $this;
    }

    /**
     * Get response.
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Parse the response.
     *
     * @param mixed $response
     */
    abstract protected function parse($response);

    /**
     * Check if response is valid.
     *
     * @param  mixed $response
     * @return bool
     */
    protected function isInvalid($response)
    {
        return is_null($response);
    }

    /**
     * Get the formatted response.
     *
     * @param string $format
     */
    public function getFormatted($format = '%s, %s - %s')
    {
        $response = $this->getResponse();

        return sprintf($format,
            array_get($response, 'street'),
            array_get($response, 'city'),
            array_get($response, 'state')
        );
    }
}
