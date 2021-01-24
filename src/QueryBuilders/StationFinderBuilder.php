<?php

namespace Flerex\SpainGas\QueryBuilders;

use Flerex\SpainGas\Dtos\GasStationLocation;
use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\Rank;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\ServiceType;
use Flerex\SpainGas\Enums\Town;
use Flerex\SpainGas\Exceptions\NetworkException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzleClient;
use stdClass;
use UnexpectedValueException;

class StationFinderBuilder
{
    private const API_ENDPOINT_URL = 'https://geoportalgasolineras.es/rest/busquedaEstacionesMapa';

    private ?Province $province;
    private ?Town $town;
    private Fuel $fuel;
    private ServiceType $serviceType;
    private SalesType $salesType;

    public function __construct()
    {
        $this->setDefaults();
    }

    /**
     * Sets the province of the builder.
     *
     * @param Province $province
     * @return $this
     */
    public function province(Province $province): StationFinderBuilder
    {
        $this->province = $province;
        return $this;
    }

    /**
     * Sets the town of the builder.
     *
     * @param Town $town
     * @return $this
     */
    public function town(Town $town): StationFinderBuilder
    {
        $this->town = $town;
        return $this;
    }

    /**
     * Sets the fuel of the builder.
     *
     * @param Fuel $fuel
     * @return $this
     */
    public function fuel(Fuel $fuel): StationFinderBuilder
    {
        $this->fuel = $fuel;
        return $this;
    }

    /**
     * Sets the service type of the builder.
     *
     * @param ServiceType $serviceType
     * @return $this
     */
    public function serviceType(ServiceType $serviceType): StationFinderBuilder
    {
        $this->serviceType = $serviceType;
        return $this;
    }

    /**
     * Sets the sales type of the builder.
     *
     * @param SalesType $salesType
     * @return $this
     */
    public function salesType(SalesType $salesType): StationFinderBuilder
    {
        $this->salesType = $salesType;
        return $this;
    }

    /**
     * Sends a request to the API endpoint and returns its output.
     *
     * @return array
     * @throws NetworkException
     */
    public function get(): array
    {
        $client = new GuzzleClient;

        try {
            $body = $this->toJson();
            $response = $client->post(static::API_ENDPOINT_URL, compact('body'));
            $data = json_decode($response->getBody());
            return array_map(fn($s) => $this->jsonObjectToDto($s), $data->estaciones->listaEstaciones);
        } catch (GuzzleException $e) {
            throw new NetworkException("Could not connect with the API gas stations endpoint.", $e);
        }
    }

    /**
     * Defines the default values for the query.
     */
    private function setDefaults()
    {
        $this->province = null;
        $this->town = null;
        $this->fuel = Fuel::ALL();
        $this->serviceType = ServiceType::ANY();
        $this->salesType = SalesType::PUBLIC();
    }

    /**
     * Returns an array with the parameters to send to the API endpoint.
     * @return string
     */
    private function toJson(): string
    {
        return json_encode(
            [
                'tipoEstacion' => 'EESS',
                'idProvincia' => (string)$this->province,
                'idMunicipio' => (string)$this->town,
                'idProducto' => (string)$this->fuel->getValue(),
                'rotulo' => '',
                'eessEconomicas' => false,
                'conPlanesDescuento' => false,
                'horarioInicial' => null,
                'horarioFinal' => null,
                'calle' => null,
                'numero' => null,
                'codPostal' => null,
                'tipoVenta' => (string)$this->salesType->getValue(),
                'tipoServicio' => (string)$this->serviceType->getValue(),
                'idOperador' => null,
                'nombrePlan' => '',
                'idTipoDestinatario' => null,
            ]
        );
    }

    /**
     * Converts the output json object provided by the API to a GasStationLocation instance.
     *
     * @param stdClass $jsonObject
     * @return GasStationLocation
     */
    private function jsonObjectToDto(stdClass $jsonObject): GasStationLocation
    {
        $station = new GasStationLocation;

        $station->id = $jsonObject->id;
        $station->latitude = $jsonObject->coordenadaX_dec;
        $station->longitude = $jsonObject->coordenadaY_dec;
        $station->price = $jsonObject->precio;

        try {
            $station->rank = new Rank($jsonObject->rango);
        } catch (UnexpectedValueException $e) {
            $station->rank = null;
        }

        return $station;
    }
}
