<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Api;

use APIPHP\Boilerplate\Exception;
use FAPI\Boilerplate\Exception\InvalidArgumentException;
use FAPI\Boilerplate\Model\Stats\ShowResponse;
use FAPI\Boilerplate\Model\Stats\TotalResponse;

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
     *
     * @throws Exception
     */
    public function show(string $username, array $params = [])
    {
        if (empty($username)) {
            throw new InvalidArgumentException('Username cannot be empty');
        }

        $response = $this->httpGet(sprintf('/v1/stats/%s', rawurlencode($username)), $params);

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, ShowResponse::class);
    }

    /**
     * @param array $params
     *
     * @return TotalResponse
     */
    public function total(array $params = [])
    {
        $response = $this->httpGet('/v1/stats/total', $params);

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, TotalResponse::class);
    }
}
