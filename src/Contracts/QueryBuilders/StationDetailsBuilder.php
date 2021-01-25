<?php

namespace Flerex\SpainGas\Contracts\QueryBuilders;

use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\ServiceType;
use Flerex\SpainGas\Exceptions\LogicException;
use Flerex\SpainGas\Exceptions\NetworkException;

interface StationDetailsBuilder
{
    /**
     * Sets the province of the builder.
     *
     * @param Province $province
     * @return $this
     */
    public function province(Province $province): StationDetailsBuilder;

    /**
     * Sets the town of the builder according to its ID.
     *
     * @param int $town
     * @return $this
     */
    public function town(int $town): StationDetailsBuilder;

    /**
     * Sets the fuel of the builder.
     *
     * @param Fuel $fuel
     * @return $this
     */
    public function fuel(Fuel $fuel): StationDetailsBuilder;

    /**
     * Sets the service type of the builder.
     *
     * @param ServiceType $serviceType
     * @return $this
     */
    public function serviceType(ServiceType $serviceType): StationDetailsBuilder;

    /**
     * Sets the sales type of the builder.
     *
     * @param SalesType $salesType
     * @return $this
     */
    public function salesType(SalesType $salesType): StationDetailsBuilder;

    /**
     * Sets the "from" geographical point used to create a bounding box to further restrict the results retrieved.
     *
     * Does not make effect if "to" is not set.
     *
     * @param float $latitude
     * @param float $longitude
     * @return $this
     */
    public function from(float $latitude, float $longitude): StationDetailsBuilder;

    /**
     * Sets the "to" geographical point used to create a bounding box to further restrict the results retrieved.
     *
     * Does not make effect if "from" is not set.
     *
     * @param float $latitude
     * @param float $longitude
     * @return $this
     */
    public function to(float $latitude, float $longitude): StationDetailsBuilder;

    /**
     * Sends a request to the API endpoint and returns its output.
     *
     * @return array
     * @throws NetworkException
     * @throws LogicException
     */
    public function get(): array;
}
