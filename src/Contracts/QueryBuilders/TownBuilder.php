<?php

namespace Flerex\SpainGas\Contracts\QueryBuilders;

use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Exceptions\MissingRequiredParameterException;
use Flerex\SpainGas\Exceptions\NetworkException;

interface TownBuilder
{
    /**
     * Sets the province of the builder.
     *
     * @param Province $province
     * @return $this
     */
    public function province(Province $province): TownBuilder;

    /**
     * Sends a request to the API endpoint and returns its output.
     *
     * @return array
     * @throws NetworkException
     * @throws MissingRequiredParameterException
     */
    public function get(): array;
}
