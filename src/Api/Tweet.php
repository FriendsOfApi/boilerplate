<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Api;

use FAPI\Boilerplate\Exception;
use FAPI\Boilerplate\Exception\Domain as DomainExceptions;
use FAPI\Boilerplate\Exception\InvalidArgumentException;
use FAPI\Boilerplate\Model\Tweet\TweetCreated;
use FAPI\Boilerplate\Model\Tweet\TweetDeleted;
use FAPI\Boilerplate\Model\Tweet\Tweets;
use FAPI\Boilerplate\Model\Tweet\Tweet as TweetModel;
use FAPI\Boilerplate\Model\Tweet\TweetUpdated;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Tweet extends HttpApi
{
    /**
     * @param array $params
     *
     * @return Tweets|ResponseInterface
     *
     * @throws Exception
     */
    public function index(array $params = [])
    {
        $response = $this->httpGet('/v1/tweets', $params);

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, Tweets::class);
    }

    /**
     * @param int $id
     *
     * @return TweetModel|ResponseInterface
     *
     * @throws Exception
     */
    public function get(int $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Id cannot be empty');
        }

        $response = $this->httpGet(sprintf('/v1/tweets/%d', $id));

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, TweetModel::class);
    }

    /**
     * @param string $message
     * @param string $location
     * @param array  $hashtags
     *
     * @return TweetCreated|ResponseInterface
     *
     * @throws Exception
     */
    public function create(string $message, string $location, array $hashtags = [])
    {
        if (empty($message)) {
            throw new InvalidArgumentException('Message cannot be empty');
        }

        if (empty($location)) {
            throw new InvalidArgumentException('Location cannot be empty');
        }

        $params = [
            'message' => $message,
            'location' => $location,
            'hashtags' => $hashtags,
        ];

        $response = $this->httpPost('/v1/tweets', $params);

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 201) {
            switch ($response->getStatusCode()) {
                case 400:
                    throw new DomainExceptions\ValidationException();
                    break;

                default:
                    $this->handleErrors($response);
                    break;
            }
        }

        return $this->hydrator->hydrate($response, TweetCreated::class);
    }

    /**
     * @param int    $id
     * @param string $message
     * @param string $location
     * @param array  $hashtags
     *
     * @return TweetUpdated|ResponseInterface
     *
     * @throws Exception
     */
    public function update(int $id, string $message, string $location, array $hashtags = [])
    {
        if (empty($message)) {
            throw new InvalidArgumentException('Message cannot be empty');
        }

        if (empty($location)) {
            throw new InvalidArgumentException('Location cannot be empty');
        }

        $params = [
            'message' => $message,
            'location' => $location,
            'hashtags' => $hashtags,
        ];

        $response = $this->httpPut(sprintf('/v1/tweets/%d', $id), $params);

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            switch ($response->getStatusCode()) {
                case 400:
                    throw new DomainExceptions\ValidationException();
                    break;

                default:
                    $this->handleErrors($response);
                    break;
            }
        }

        return $this->hydrator->hydrate($response, TweetUpdated::class);
    }

    /**
     * @param int $id
     *
     * @return TweetDeleted|ResponseInterface
     *
     * @throws Exception
     */
    public function delete(int $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Id cannot be empty');
        }

        $response = $this->httpDelete(sprintf('/v1/tweets/%d', $id));

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, TweetDeleted::class);
    }
}
