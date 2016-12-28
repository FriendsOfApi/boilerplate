<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Model\Tweet;

use FAPI\Boilerplate\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class DeleteResponse implements CreatableFromArray
{
    private $message;

    /**
     * @param string $message
     */
    private function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @param array $data
     *
     * @return DeleteResponse
     */
    public static function createFromArray(array $data)
    {
        $message = '';

        if (isset($data['message'])) {
            $message = $data['message'];
        }

        return new self($message);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
