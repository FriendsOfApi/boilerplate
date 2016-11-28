<?php

/*
 *
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace APIPHP\Boilerplate\Api;

use APIPHP\Boilerplate\Assert;
use APIPHP\Boilerplate\Exception\InvalidArgumentException;
use APIPHP\Boilerplate\Resource\Api\Stats\AllResponse;
use APIPHP\Boilerplate\Resource\Api\Stats\TotalResponse;

/**
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Stats extends HttpApi
{
    /**
     * @param string $username
     * @param array  $params
     *
     * @return TotalResponse
     */
    public function total($username, array $params = [])
    {
        if (empty($username)) {
            throw new InvalidArgumentException('Username cannot be empty');
        }

        $response = $this->httpGet(sprintf('/v3/%s/stats/total', rawurlencode($username)), $params);

        return $this->deserializer->deserialize($response, TotalResponse::class);
    }
}
