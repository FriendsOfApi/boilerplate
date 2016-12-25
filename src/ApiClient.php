<?PHP

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\Boilerplate;

use FAPI\Boilerplate\Api\Stats;
use FAPI\Boilerplate\Api\Tweet;
use Http\Client\Common\HttpMethodsClient;
use FAPI\Boilerplate\Hydrator\ModelHydrator;
use FAPI\Boilerplate\Hydrator\ResponseHydrator;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ApiClient
{
    /**
     * @var HttpMethodsClient
     */
    private $httpClient;

    /**
     * @var ResponseHydrator
     */
    private $deserializer;

    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * @param string                      $apiKey
     * @param ResponseHydrator|null       $deserializer
     * @param HttpClientConfigurator|null $clientConfigurator
     * @param RequestBuilder|null         $requestBuilder
     */
    public function __construct(
        $apiKey = null,
        ResponseHydrator $deserializer = null,
        HttpClientConfigurator $clientConfigurator = null,
        RequestBuilder $requestBuilder = null
    ) {
        $clientConfigurator = $clientConfigurator ?: new HttpClientConfigurator();
        if ($apiKey) {
            $clientConfigurator->setApiKey($apiKey);
        }
        $this->httpClient = $clientConfigurator->createConfiguredClient();
        $this->requestBuilder = $requestBuilder ?: new RequestBuilder();
        $this->deserializer = $deserializer ?: new ModelHydrator();
    }

    /**
     * @return Api\Tweet
     */
    public function tweets(): Tweet
    {
        return new Api\Tweet($this->httpClient, $this->requestBuilder, $this->deserializer);
    }

    /**
     * @return Api\Stats
     */
    public function stats(): Stats
    {
        return new Api\Stats($this->httpClient, $this->requestBuilder, $this->deserializer);
    }
}
