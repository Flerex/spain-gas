<?php

namespace Flerex\SpainGas\Dtos;

use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\Rank;

final class GasStationInfo
{
    public int $id;
    public string $pricing;
    public float $station;
    public float $longitude;
    public Rank $rank;
}
