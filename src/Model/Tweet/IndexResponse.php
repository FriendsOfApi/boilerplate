<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Model\Tweet;

use FAPI\Boilerplate\\ApiResponse;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class IndexResponse implements ApiResponse
{
    private $message;

    private $tweets;

    /**
     * @param string $message
     * @param array  $tweets
     */
    private function __construct(string $message, array $tweets)
    {
        $this->message = $message;
        $this->tweets = $tweets;
    }

    /**
     * @param array $data
     *
     * @return IndexResponse
     */
    public static function create(array $data)
    {
        $message = '';
        $tweets = [];

        if (isset($data['tweets'])) {
            foreach ($data['tweets'] as $item) {
                $tweets[] = Tweet::create($item);
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
