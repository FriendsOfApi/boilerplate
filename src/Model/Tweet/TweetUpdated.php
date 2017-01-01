<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Model\Tweet;

use FAPI\Boilerplate\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class TweetUpdated implements CreatableFromArray
{
    /**
     * @var string
     */
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
     * @return TweetUpdated
     */
    public static function createFromArray(array $data): TweetUpdated
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
