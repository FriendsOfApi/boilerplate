<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\Boilerplate;

use FAPI\Boilerplate\Api\Stats;
use FAPI\Boilerplate\Api\Tweet;
use Http\Client\Common\HttpMethodsClient;
use FAPI\Boilerplate\Hydrator\ModelHydrator;
use FAPI\Boilerplate\Hydrator\Hydrator;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class ApiClient
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * The constructor accepts already configured HTTP clients.
     * Use the configure method to pass a configuration to the Client and create an HTTP Client.
     *
     * @param HttpClient          $httpClient
     * @param Hydrator|null       $hydrator
     * @param RequestBuilder|null $requestBuilder
     */
    public function __construct(
        HttpClient $httpClient,
        Hydrator $hydrator = null,
        RequestBuilder $requestBuilder = null
    ) {
        $this->httpClient = $httpClient;
        $this->hydrator = $hydrator ?: new ModelHydrator();
        $this->requestBuilder = $requestBuilder ?: new RequestBuilder();
    }

    /**
     * @param HttpClientConfigurator $httpClientConfigurator
     * @param Hydrator|null          $hydrator
     * @param RequestBuilder|null    $requestBuilder
     *
     * @return ApiClient
     */
    public static function configure(
        HttpClientConfigurator $httpClientConfigurator,
        Hydrator $hydrator = null,
        RequestBuilder $requestBuilder = null
    ): self {
        $httpClient = $httpClientConfigurator->createConfiguredClient();

        return new self($httpClient, $hydrator, $requestBuilder);
    }

    /**
     * @param string $apiKey
     *
     * @return ApiClient
     */
    public static function create(string $apiKey): self {
        $httpClientConfigurator = (new HttpClientConfigurator)->setApiKey($apiKey);

        return self::configure($httpClientConfigurator);
    }

    /**
     * @return Api\Tweet
     */
    public function tweets(): Tweet
    {
        return new Api\Tweet($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @return Api\Stats
     */
    public function stats(): Stats
    {
        return new Api\Stats($this->httpClient, $this->hydrator, $this->requestBuilder);
    }
}
