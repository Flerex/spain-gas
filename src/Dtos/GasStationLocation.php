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
     * Latitude object of the coordinates of the gas station.
     * @var Location
     */
    public Location $location;

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
