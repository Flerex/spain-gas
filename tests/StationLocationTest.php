<?php

namespace Flerex\SpainGas\Tests;

use Flerex\SpainGas\Dtos\GasStationLocation;
use Flerex\SpainGas\Dtos\Location;
use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\Rank;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\ServiceType;
use Flerex\SpainGas\Exceptions\NetworkException;
use Flerex\SpainGas\GasApi;
use PHPUnit\Framework\TestCase;

final class StationLocationTest extends TestCase
{
    /** @test
     * When not filtering by fuel parameters price and rank are provided.
     *
     * @throws NetworkException
     */
    public function obtain_stations_for_province()
    {
        $stations = GasApi::locateGasStations()
            ->province(Province::A_CORUNA())
            ->get();

        $this->assertIsArray($stations);
        $this->assertTrue(count($stations) > 0);

        /** @var GasStationLocation $station */
        $station = $stations[0];

        $this->assertInstanceOf(GasStationLocation::class, $station);
        $this->assertInstanceOf(Location::class, $station->location);
        $this->assertIsFloat($station->location->latitude);
        $this->assertIsFloat($station->location->longitude);
        $this->assertNull($station->price);
        $this->assertNull($station->rank);
    }

    /**
     * @test When filtering by fuel parameters price and rank are provided.
     * @throws NetworkException
     */
    public function obtain_stations_for_province_by_fuel()
    {
        $stations = GasApi::locateGasStations()
            ->province(Province::A_CORUNA())
            ->salesType(SalesType::PUBLIC())
            ->serviceType(ServiceType::ANY())
            ->fuel(Fuel::CNG())
            ->get();

        $this->assertIsArray($stations);
        $this->assertTrue(count($stations) > 0);

        /** @var GasStationLocation $station */
        $station = $stations[0];

        $this->assertInstanceOf(GasStationLocation::class, $station);
        $this->assertInstanceOf(Location::class, $station->location);
        $this->assertIsFloat($station->location->latitude);
        $this->assertIsFloat($station->location->longitude);
        $this->assertIsFloat($station->price);
        $this->assertInstanceOf(Rank::class, $station->rank);
    }

    /** @test The special output when no station is found
     *
     * @throws NetworkException
     */
    public function obtain_no_stations_for_query()
    {
        $stations = GasApi::locateGasStations()
            ->province(Province::LUGO())
            ->fuel(Fuel::HYDROGEN())
            ->get();

        $this->assertIsArray($stations);
        $this->assertTrue(count($stations) == 0);
    }
}
