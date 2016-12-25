<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Resource\Api\Stats;

use FAPI\Boilerplate\Resource\ApiResponse;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class ShowResponse implements ApiResponse
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
    private function __construct(\DateTime $start, \DateTime $end, $count)
    {
        $this->start = $start;
        $this->end = $end;
        $this->count = $count;
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public static function create(array $data)
    {
        return new self(new \DateTime($data['start']), new \DateTime($data['end']), $data['count']);
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }
}
