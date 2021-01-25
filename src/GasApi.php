<?php


namespace Flerex\SpainGas;

use Flerex\SpainGas\Contracts\GasApi as GasApiContract;
use Flerex\SpainGas\QueryBuilders\StationDetailsBuilder;
use Flerex\SpainGas\QueryBuilders\StationFinderBuilder;

final class GasApi implements GasApiContract
{

    /** @inheritDoc */
    public static function gasStations(): StationFinderBuilder
    {
        return new StationFinderBuilder;
    }

    /** @inheritDoc */
    public static function stationsDetails(): StationDetailsBuilder
    {
        return new StationDetailsBuilder;
    }

    /**
     * Non-instantiable class.
     */
    private function __construct()
    {
    }
}
