<?php

namespace Flerex\SpainGas\Tests;

use Flerex\SpainGas\GasApi;
use Flerex\SpainGas\QueryBuilders\StationLocationBuilder;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class GasApiTest extends TestCase
{
    /** @test
     * The StationLocationBuilder must be accessible through this class.
     */
    public function provides_interface_with_station_finder()
    {
        $gasStationFinderBuilder = GasApi::locateGasStations();

        $this->assertInstanceOf(StationLocationBuilder::class, $gasStationFinderBuilder);
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
