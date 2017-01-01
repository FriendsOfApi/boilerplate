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
final class Tweet implements CreatableFromArray
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $user;

    /**
     * @var array
     */
    private $hashtags;

    /**
     * @var string
     */
    private $location;

    /**
     * @var \DateTimeInterface
     */
    private $createdAt;

    /**
     * @param string             $message
     * @param string             $user
     * @param string             $location
     * @param array              $hashtags
     * @param \DateTimeInterface $createdAt
     */
    private function __construct(string $message, string $user, string $location, array $hashtags, \DateTimeInterface $createdAt)
    {
        $this->message = $message;
        $this->user = $user;
        $this->hashtags = $hashtags;
        $this->location = $location;
        $this->createdAt = $createdAt;
    }

    /**
     * @param array $data
     *
     * @return Tweet
     */
    public static function createFromArray(array $data): Tweet
    {
        // TODO some validation on input

        return new self($data['message'], $data['user'], $data['location'], $data['hashtags'], new \DateTimeImmutable($data['timestamp']));
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
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
