<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace APIPHP\Boilerplate\Deserializer;

use APIPHP\Boilerplate\Exception\DeserializeException;
use APIPHP\Boilerplate\Resource\ApiResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Serialize an HTTP response to domain object.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ModelDeserializer implements ResponseDeserializer
{
    /**
     * @param ResponseInterface $response
     * @param string            $class
     *
     * @return mixed
     */
    public function deserialize(ResponseInterface $response, string $class)
    {
        $body = $response->getBody()->__toString();
        if (strpos($response->getHeaderLine('Content-Type'), 'application/json') !== 0) {
            throw new DeserializeException('The ModelDeserializer cannot deserialize response with Content-Type:'.$response->getHeaderLine('Content-Type'));
        }

        $data = json_decode($body, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new DeserializeException(sprintf('Error (%d) when trying to json_decode response', json_last_error()));
        }

        if (is_subclass_of($class, ApiResponse::class)) {
            $object = call_user_func($class.'::create', $data);
        } else {
            $object = new $class($data);
        }

        return $object;
    }
}
