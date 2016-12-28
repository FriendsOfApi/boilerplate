<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Model\Tweet;

/**
 * A representation of a Tweet. It can be shared between multiple responses.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Tweet
{
    private $message;

    private $user;

    private $hashtags;

    private $location;

    private $createdAt;

    /**
     * @param string    $message
     * @param string    $user
     * @param string    $location
     * @param array     $hashtags
     * @param \DateTime $createdAt
     */
    private function __construct(string $message, string $user, string $location, array $hashtags, \DateTime $createdAt)
    {
        $this->message = $message;
        $this->user = $user;
        $this->hashtags = $hashtags;
        $this->location = $location;
        $this->createdAt = $createdAt;
    }

    public static function create(array $data)
    {
        // TODO some validation on input

        return new self($data['message'], $data['user'], $data['location'], $data['hashtags'], new \DateTime($data['timestamp']));
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getHashtags(): array
    {
        return $this->hashtags;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
