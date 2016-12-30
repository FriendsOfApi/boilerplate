<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Api;

use APIPHP\Boilerplate\Exception;
use FAPI\Boilerplate\Exception\InvalidArgumentException;
use FAPI\Boilerplate\Model\Stats\Stat;
use FAPI\Boilerplate\Model\Stats\Total;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Stats extends HttpApi
{
    /**
     * @param string $username
     * @param array  $params
     *
     * @return Stat
     *
     * @throws Exception
     */
    public function show(string $username, array $params = [])
    {
        if (empty($username)) {
            throw new InvalidArgumentException('Username cannot be empty');
        }

        $response = $this->httpGet(sprintf('/v1/stats/%s', rawurlencode($username)), $params);

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, Stat::class);
    }

    /**
     * @param array $params
     *
     * @return Total
     */
    public function total(array $params = [])
    {
        $response = $this->httpGet('/v1/stats/total', $params);

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, Total::class);
    }
}
