<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Model\Stats;

use FAPI\Boilerplate\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Total implements CreatableFromArray
{
    /**
     * @var \DateTime
     */
    private $start;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * @var int
     */
    private $count;

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @param int       $count
     */
    private function __construct(\DateTime $start, \DateTime $end, int $count)
    {
        $this->start = $start;
        $this->end = $end;
        $this->count = $count;
    }

    /**
     * @param array $data
     *
     * @return Total
     */
    public static function createFromArray(array $data): Total
    {
        return new self(new \DateTime($data['start']), new \DateTime($data['end']), $data['count']);
    }

    /**
     * @return \DateTime
     */
    public function getStart(): \DateTime
    {
        return $this->start;
    }

    /**
     * @return \DateTime
     */
    public function getEnd(): \DateTime
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
