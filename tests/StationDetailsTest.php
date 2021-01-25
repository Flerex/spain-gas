<?php

namespace Flerex\SpainGas\Tests;

use DateTime;
use Flerex\SpainGas\Dtos\GasStation;
use Flerex\SpainGas\Dtos\GasStationLocation;
use Flerex\SpainGas\Dtos\Location;
use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\Rank;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\ServiceType;
use Flerex\SpainGas\Exceptions\LogicException;
use Flerex\SpainGas\Exceptions\NetworkException;
use Flerex\SpainGas\GasApi;
use PHPUnit\Framework\TestCase;

final class StationDetailsTest extends TestCase
{
    /** @test GasStation returns correct values.
     *
     * @throws NetworkException
     * @throws LogicException
     */
    public function obtain_stations_for_province()
    {
        $stations = GasApi::gasStations()
            ->province(Province::MADRID())
            ->fuel(Fuel::CNG())
            ->get();

        $this->assertIsArray($stations);
        $this->assertTrue(count($stations) > 0);

        /** @var GasStation $station */
        $station = $stations[0];

        $this->assertIsNumeric($station->id);
        $this->assertInstanceOf(GasStation::class, $station);
        $this->assertInstanceOf(Location::class, $station->location);
        $this->assertIsFloat($station->location->latitude);
        $this->assertIsFloat($station->location->longitude);
        $this->assertInstanceOf(DateTime::class, $station->priceLastUpdatedAt);
    }

    /**
     * @test Not providing fuel does not return price.
     *
     * @throws NetworkException
     * @throws LogicException
     */
    public function obtain_stations_for_province_by_fuel()
    {
        $stations = GasApi::gasStations()
            ->province(Province::MADRID())
            ->get();

        $this->assertIsArray($stations);
        $this->assertTrue(count($stations) > 0);

        /** @var GasStation $station */
        $station = $stations[0];

        $this->assertIsNumeric($station->id);
        $this->assertInstanceOf(GasStation::class, $station);
        $this->assertInstanceOf(Location::class, $station->location);
        $this->assertIsFloat($station->location->latitude);
        $this->assertIsFloat($station->location->longitude);
        $this->assertInstanceOf(DateTime::class, $station->priceLastUpdatedAt);
        $this->assertNull($station->price);
    }
}
