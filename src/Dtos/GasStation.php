<?php

namespace Flerex\SpainGas\Dtos;

use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\Rank;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\Town;

final class GasStation
{
    public int $id;
    public string $label;
    public string $owner;
    public string $address;
    public string $postalCode;
    public Province $province;
    public Town $town;
    public SalesType $salesType;

    public float $latitude;
    public float $longitude;

    public string $schedule;

    public float $averageRating;
    public int $numberRating;
}
