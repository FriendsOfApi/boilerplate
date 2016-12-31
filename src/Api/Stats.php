<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Api;

use FAPI\Boilerplate\Exception;
use FAPI\Boilerplate\Exception\InvalidArgumentException;
use FAPI\Boilerplate\Model\Stats\Stat;
use FAPI\Boilerplate\Model\Stats\Total;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Stats extends HttpApi
{
    /**
     * @param string $username
     * @param array  $params
     *
     * @return Stat|ResponseInterface
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
     * @return Total|ResponseInterface
     *
     * @throws Exception
     */
    public function total(array $params = [])
    {
        $response = $this->httpGet('/v1/stats', $params);

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
