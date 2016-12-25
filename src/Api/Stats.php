<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Fapi\Boilerplate\Api;

use Fapi\Boilerplate\Exception\InvalidArgumentException;
use Fapi\Boilerplate\Resource\Api\Stats\TotalResponse;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Stats extends HttpApi
{
    /**
     * @param string $username
     * @param array  $params
     *
     * @return ShowResponse
     */
    public function show(string $username, array $params = [])
    {
        if (empty($username)) {
            throw new InvalidArgumentException('Username cannot be empty');
        }

        $response = $this->httpGet(sprintf('/v1/stats/%s', rawurlencode($username)), $params);

        // TODO handle non 200 responses

        return $this->deserializer->deserialize($response, ShowResponse::class);
    }

    /**
     * @param array $params
     *
     * @return TotalResponse
     */
    public function total(array $params = [])
    {
        $response = $this->httpGet('/v1/stats/total', $params);

        // TODO handle non 200 responses

        return $this->deserializer->deserialize($response, TotalResponse::class);
    }
}
