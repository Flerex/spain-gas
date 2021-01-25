<?php

namespace Flerex\SpainGas\QueryBuilders;

use Flerex\SpainGas\Dtos\Town;
use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Exceptions\MissingRequiredParameterException;
use Flerex\SpainGas\Exceptions\NetworkException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class TownBuilder
{
    private const API_ENDPOINT_URL = 'https://geoportalgasolineras.es/rest/getLocalidades';

    private Province $province;

    /**
     * Sets the province of the builder.
     *
     * @param Province $province
     * @return $this
     */
    public function province(Province $province): TownBuilder
    {
        $this->province = $province;
        return $this;
    }

    /**
     * Sends a request to the API endpoint and returns its output.
     *
     * @return array
     * @throws NetworkException
     * @throws MissingRequiredParameterException
     */
    public function get(): array
    {

        if (!isset($this->province)) {
            throw new MissingRequiredParameterException('You need to provide a Province object to obtain the results for.');
        }

        $client = new GuzzleClient;

        try {
            $query = [
                'idProvincia' => $this->province->getValue(),
            ];
            $response = $client->post(static::API_ENDPOINT_URL, compact('query'));
            $data = json_decode($response->getBody());
            return array_map(fn($s) => $this->jsonObjectToDto($s), $data->localidades);
        } catch (GuzzleException $e) {
            throw new NetworkException("Could not connect with the API gas stations endpoint.", $e);
        }
    }

    /**
     * Converts the output json object provided by the API to a Town instance.
     *
     * @param stdClass $jsonObject
     * @return Town
     */
    private function jsonObjectToDto(stdClass $jsonObject): Town
    {
        return new Town($jsonObject->id, $jsonObject->nombre);
    }
}
