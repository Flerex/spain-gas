<?php

namespace Flerex\SpainGas\Dtos;

use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\Rank;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\Town;

final class DegreesCoordinate
{
    public int $degrees;
    public int $minutes;
    public int $seconds;
    public string $descriptor;

    /**
     * DegreesCoordinate constructor.
     *
     * The $positive and $negative parameters represent the descriptors for when those values are either
     * positive or negative. This is used to remove the negative value from the degrees and show instead the descriptor
     * in the end of the normalized string.
     *
     * @param float $coordinate
     * @param string $positive
     * @param string $negative
     */
    public function __construct(float $coordinate, string $positive, string $negative)
    {
        $this->descriptor = $coordinate >= 0 ? $positive : $negative;

        $coor = abs($coordinate);
        $this->degrees = floor($coor);

        $coor = ($coor - $this->degrees) * 60;
        $this->minutes = floor($coor);

        $coor = ($coor - $this->minutes) * 60;
        $this->seconds = floor($coor);
    }

    /**
     * Returns a string equivalent of the coordinates in the standard from <degrees>º <minutes>' <seconds>" <descriptor>.
     *
     * @return string
     */
    public function normalize(): string
    {
        return "{$this->degrees}º {$this->minutes}' {$this->seconds}\" {$this->descriptor}";
    }

    public function __toString(): string
    {
        return $this->normalize();
    }
}
