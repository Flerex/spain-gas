<?php

namespace Flerex\SpainGas\Contracts\QueryBuilders;

use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\ServiceType;
use Flerex\SpainGas\Exceptions\NetworkException;

interface StationLocationBuilder
{

    /**
     * Sets the province of the builder.
     *
     * @param Province $province
     * @return $this
     */
    public function province(Province $province): StationLocationBuilder;

    /**
     * Sets the town of the builder.
     *
     * @param int $town
     * @return $this
     */
    public function town(int $town): StationLocationBuilder;

    /**
     * Sets the fuel of the builder.
     *
     * @param Fuel $fuel
     * @return $this
     */
    public function fuel(Fuel $fuel): StationLocationBuilder;

    /**
     * Sets the service type of the builder.
     *
     * @param ServiceType $serviceType
     * @return $this
     */
    public function serviceType(ServiceType $serviceType): StationLocationBuilder;

    /**
     * Sets the sales type of the builder.
     *
     * @param SalesType $salesType
     * @return $this
     */
    public function salesType(SalesType $salesType): StationLocationBuilder;

    /**
     * Sends a request to the API endpoint and returns its output.
     *
     * @return array
     * @throws NetworkException
     */
    public function get(): array;
}
