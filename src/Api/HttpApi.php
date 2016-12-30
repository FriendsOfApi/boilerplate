<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Api;

use FAPI\Boilerplate\Exception\Domain as DomainExceptions;
use FAPI\Boilerplate\Exception\DomainException;
use FAPI\Boilerplate\Hydrator\NoopHydrator;
use Http\Client\HttpClient;
use FAPI\Boilerplate\Hydrator\Hydrator;
use FAPI\Boilerplate\RequestBuilder;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class HttpApi
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * @var RequestBuilder
     */
    protected $requestBuilder;

    /**
     * @param HttpClient     $httpClient
     * @param RequestBuilder $requestBuilder
     * @param Hydrator       $hydrator
     */
    public function __construct(HttpClient $httpClient, Hydrator $hydrator, RequestBuilder $requestBuilder)
    {
        $this->httpClient = $httpClient;
        $this->requestBuilder = $requestBuilder;
        if (!$hydrator instanceof NoopHydrator) {
            $this->hydrator = $hydrator;
        }
    }

    /**
     * Send a GET request with query parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     GET parameters.
     * @param array  $requestHeaders Request Headers.
     *
     * @return ResponseInterface
     */
    protected function httpGet($path, array $parameters = [], array $requestHeaders = []): ResponseInterface
    {
        if (count($parameters) > 0) {
            $path .= '?'.http_build_query($parameters);
        }

        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('GET', $path, $requestHeaders)
        );
    }

    /**
     * Send a POST request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return ResponseInterface
     */
    protected function httpPost($path, array $parameters = [], array $requestHeaders = []): ResponseInterface
    {
        return $this->httpPostRaw($path, $this->createJsonBody($parameters), $requestHeaders);
    }

    /**
     * Send a POST request with raw data.
     *
     * @param string       $path           Request path.
     * @param array|string $body           Request body.
     * @param array        $requestHeaders Request headers.
     *
     * @return ResponseInterface
     */
    protected function httpPostRaw($path, $body, array $requestHeaders = []): ResponseInterface
    {
        return $response = $this->httpClient->sendRequest(
            $this->requestBuilder->create('POST', $path, $requestHeaders, $body)
        );
    }

    /**
     * Send a PUT request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return ResponseInterface
     */
    protected function httpPut($path, array $parameters = [], array $requestHeaders = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('PUT', $path, $requestHeaders, $this->createJsonBody($parameters))
        );
    }

    /**
     * Send a DELETE request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return ResponseInterface
     */
    protected function httpDelete($path, array $parameters = [], array $requestHeaders = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('DELETE', $path, $requestHeaders, $this->createJsonBody($parameters))
        );
    }

    /**
     * Create a JSON encoded version of an array of parameters.
     *
     * @param array $parameters Request parameters
     *
     * @return null|string
     */
    private function createJsonBody(array $parameters)
    {
        return (count($parameters) === 0) ? null : json_encode($parameters, empty($parameters) ? JSON_FORCE_OBJECT : 0);
    }

    /**
     * Handle HTTP errors.
     *
     * Call is controlled by the specific API methods.
     *
     * @param ResponseInterface $response
     *
     * @throws DomainException
     */
    protected function handleErrors(ResponseInterface $response)
    {
        switch ($response->getStatusCode()) {
            case 404:
                throw new DomainExceptions\NotFoundException();
                break;

            default:
                throw new DomainExceptions\UnknownErrorException();
                break;
        }
    }
}
