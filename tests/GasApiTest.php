<?php

namespace Flerex\SpainGas\Tests;

use Flerex\SpainGas\Dtos\GasStationLocation;
use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\Enums\Rank;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\ServiceType;
use Flerex\SpainGas\Exceptions\NetworkException;
use Flerex\SpainGas\GasApi;
use Flerex\SpainGas\QueryBuilders\StationFinderBuilder;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class GasApiTest extends TestCase
{
    /** @test
     * The StationFinderBuilder must be accessible through this class.
     */
    public function provides_interface_with_station_finder()
    {
        $gasStationFinderBuilder = GasApi::gasStations();

        $this->assertInstanceOf(StationFinderBuilder::class, $gasStationFinderBuilder);
    }

    /** @test
     * This class should only be used statically and, hence, instantiation is not possible.
     */
    public function cannot_be_instantiated()
    {
        $this->expectException(\ReflectionException::class);

        $class = new ReflectionClass(GasApi::class);
        $constructor = $class->getConstructor();
        $this->assertTrue($constructor->isPrivate());

        $class->newInstance();
    }

}
