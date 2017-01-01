<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Model\Stat;

use FAPI\Boilerplate\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Stat implements CreatableFromArray
{
    /**
     * @var \DateTimeInterface
     */
    private $start;

    /**
     * @var \DateTimeInterface
     */
    private $end;

    /**
     * @var int
     */
    private $count;

    /**
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @param int                $count
     */
    private function __construct(\DateTimeInterface $start, \DateTimeInterface $end, int $count)
    {
        $this->start = $start;
        $this->end = $end;
        $this->count = $count;
    }

    /**
     * @param array $data
     *
     * @return Stat
     */
    public static function createFromArray(array $data): Stat
    {
        return new self(new \DateTimeImmutable($data['start']), new \DateTimeImmutable($data['end']), $data['count']);
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStart(): \DateTimeInterface
    {
        return $this->start;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEnd(): \DateTimeInterface
    {
        return $this->end;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
}
