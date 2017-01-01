<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Model\Tweet;

use FAPI\Boilerplate\Exception\InvalidArgumentException;
use FAPI\Boilerplate\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Tweets implements CreatableFromArray
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var Tweet[]
     */
    private $tweets;

    /**
     * @param string  $message
     * @param Tweet[] $tweets
     */
    private function __construct(string $message, array $tweets)
    {
        foreach ($tweets as $tweet) {
            if (!$tweet instanceof Tweet) {
                throw new InvalidArgumentException('All tweets must be an instance of '.Tweet::class);
            }
        }

        $this->message = $message;
        $this->tweets = $tweets;
    }

    /**
     * @param array $data
     *
     * @return Tweets
     */
    public static function createFromArray(array $data): Tweets
    {
        $message = '';
        $tweets = [];

        if (isset($data['tweets'])) {
            foreach ($data['tweets'] as $item) {
                $tweets[] = Tweet::createFromArray($item);
            }
        }

        if (isset($data['message'])) {
            $message = $data['message'];
        }

        return new self($message, $tweets);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return Tweet[]
     */
    public function getTweets(): array
    {
        return $this->tweets;
    }
}
