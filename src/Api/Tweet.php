<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Api;

use FAPI\Boilerplate\Exception\InvalidArgumentException;
use FAPI\Boilerplate\Resource\Api\Tweet\CreateResponse;
use FAPI\Boilerplate\Resource\Api\Tweet\DeleteResponse;
use FAPI\Boilerplate\Resource\Api\Tweet\IndexResponse;
use FAPI\Boilerplate\Resource\Api\Tweet\ShowResponse;
use FAPI\Boilerplate\Resource\Api\Tweet\UpdateResponse;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Tweet extends HttpApi
{
    /**
     * @param array $params
     *
     * @return IndexResponse
     */
    public function index(array $params = [])
    {
        $response = $this->httpGet('/v1/tweets', $params);

        // TODO handle non 200 responses

        return $this->deserializer->deserialize($response, IndexResponse::class);
    }

    /**
     * @param int $id
     *
     * @return ShowResponse
     */
    public function show(int $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Id cannot be empty');
        }

        $response = $this->httpGet(sprintf('/v1/tweets/%d', $id));

        // TODO handle non 200 responses

        return $this->deserializer->deserialize($response, ShowResponse::class);
    }

    /**
     * @param string $message
     * @param string $location
     * @param array  $hashtags
     *
     * @return CreateResponse
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

        $response = $this->httpPost('/v1/tweets/new', $params);

        // TODO handle non 200 responses

        return $this->deserializer->deserialize($response, CreateResponse::class);
    }

    /**
     * @param int    $id
     * @param string $message
     * @param string $location
     * @param array  $hashtags
     *
     * @return UpdateResponse
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

        $response = $this->httpPut(sprintf('/v1/tweets/%d/edit', $id), $params);

        // TODO handle non 200 responses

        return $this->deserializer->deserialize($response, UpdateResponse::class);
    }

    /**
     * @param int $id
     *
     * @return DeleteResponse
     */
    public function delete(int $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Id cannot be empty');
        }

        $response = $this->httpDelete(sprintf('/v1/tweets/%d', $id));

        // TODO handle non 200 responses

        return $this->deserializer->deserialize($response, DeleteResponse::class);
    }
}
