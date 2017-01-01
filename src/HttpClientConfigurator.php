<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate;

use Http\Client\HttpClient;
use Http\Client\Common\PluginClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\Authentication;
use Http\Message\UriFactory;
use Http\Client\Common\Plugin;

/**
 * Configure an HTTP client.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 *
 * @internal This class should not be used outside of the API Client, it is not part of the BC promise.
 */
final class HttpClientConfigurator
{
    /**
     * @var string
     */
    private $endpoint = 'https://fake-twitter.com';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var UriFactory
     */
    private $uriFactory;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Plugin[]
     */
    private $prependPlugins = [];

    /**
     * @var Plugin[]
     */
    private $appendPlugins = [];

    /**
     * @param HttpClient|null $httpClient
     * @param UriFactory|null $uriFactory
     */
    public function __construct(HttpClient $httpClient = null, UriFactory $uriFactory = null)
    {
        $this->httpClient = $httpClient ?? HttpClientDiscovery::find();
        $this->uriFactory = $uriFactory ?? UriFactoryDiscovery::find();
    }

    /**
     * @return HttpClient
     */
    public function createConfiguredClient(): HttpClient
    {
        $plugins = $this->prependPlugins;

        $plugins[] = new Plugin\AddHostPlugin($this->uriFactory->createUri($this->endpoint));
        $plugins[] = new Plugin\HeaderDefaultsPlugin([
            'User-Agent' => 'FriendsOfApi/boilerplate (https://github.com/FriendsOfApi/boilerplate)',
        ]);

        if (null !== $this->apiKey) {
            $plugins[] = new Plugin\AuthenticationPlugin(new Authentication\Bearer($this->apiKey));
        }

        return new PluginClient($this->httpClient, array_merge($plugins, $this->appendPlugins));
    }

    /**
     * @param string $endpoint
     *
     * @return HttpClientConfigurator
     */
    public function setEndpoint(string $endpoint): HttpClientConfigurator
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @param string $apiKey
     *
     * @return HttpClientConfigurator
     */
    public function setApiKey(string $apiKey): HttpClientConfigurator
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @param Plugin $plugin
     *
     * @return HttpClientConfigurator
     */
    public function appendPlugin(Plugin ...$plugin): HttpClientConfigurator
    {
        foreach ($plugin as $p) {
            $this->appendPlugins[] = $p;
        }

        return $this;
    }

    /**
     * @param Plugin $plugin
     *
     * @return HttpClientConfigurator
     */
    public function prependPlugin(Plugin ...$plugin): HttpClientConfigurator
    {
        $plugin = array_reverse($plugin);
        foreach ($plugin as $p) {
            array_unshift($this->prependPlugins, $p);
        }

        return $this;
    }
}
