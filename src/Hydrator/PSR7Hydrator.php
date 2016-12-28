<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Hydrator;

use Psr\Http\Message\ResponseInterface;

/**
 * Do not hydrate to any object at all. Just return a PSR-7 response.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class PSR7Hydrator implements Hydrator
{
    /**
     * @param ResponseInterface $response
     * @param string            $class
     *
     * @return ResponseInterface
     */
    public function hydrate(ResponseInterface $response, string $class): ResponseInterface
    {
        return $response;
    }
}
