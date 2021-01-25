<?php

namespace Flerex\SpainGas\Tests;

use Flerex\SpainGas\Dtos\GasStationLocation;
use Flerex\SpainGas\Dtos\Location;
use Flerex\SpainGas\Dtos\Town;
use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\Rank;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\ServiceType;
use Flerex\SpainGas\Exceptions\MissingRequiredParameterException;
use Flerex\SpainGas\Exceptions\NetworkException;
use Flerex\SpainGas\GasApi;
use PHPUnit\Framework\TestCase;

final class TownTest extends TestCase
{
    /** @test
     * Expected behavior of the class.
     *
     * @throws NetworkException
     * @throws MissingRequiredParameterException
     */
    public function obtain_towns_for_province()
    {
        $towns = GasApi::towns()
            ->province(Province::A_CORUNA())
            ->get();

        $this->assertIsArray($towns);
        $this->assertTrue(count($towns) > 0);

        /** @var Town $town */
        $town = $towns[0];

        $this->assertInstanceOf(Town::class, $town);
        $this->assertIsNumeric($town->id);
        $this->assertIsString($town->name);
    }

    /** @test
     * Expected behavior of the class.
     *
     * @throws NetworkException
     * @throws MissingRequiredParameterException
     */
    public function province_parameter_is_requiered()
    {
        $this->expectException(MissingRequiredParameterException::class);
        GasApi::towns()->get();
    }

}
