<?php

namespace Flerex\SpainGas\Dtos;

use Flerex\SpainGas\Enums\Rank;

final class GasStationLocation
{
    /**
     * The internal ID used in Geoportal Gasolineras
     * @var int
     */
    public int $id;

    /**
     * Decimal latitude of the coordinates of the gas station.
     * @var float
     */
    public float $latitude;

    /**
     * Decimal longitude of the coordinates of the gas station.
     * @var float
     */
    public float $longitude;

    /**
     * When fuel is specified as a filter, pricing in the gas station. Null otherwise,
     * @var float|null
     */
    public ?float $price;

    /**
     * When fuel is specified as a filter, ranking of the pricing in the gas station. Null otherwise.
     * @var Rank|null
     */
    public ?Rank $rank;
}
