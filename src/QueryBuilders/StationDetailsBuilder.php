<?php

namespace Flerex\SpainGas\QueryBuilders;

use Flerex\SpainGas\Dtos\Address;
use Flerex\SpainGas\Dtos\GasStation;
use Flerex\SpainGas\Dtos\Location;
use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\ServiceType;
use Flerex\SpainGas\Enums\Town;
use Flerex\SpainGas\Exceptions\NetworkException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class StationDetailsBuilder
{
    private const API_ENDPOINT_URL = 'https://geoportalgasolineras.es/rest/busquedaEstacionesInfo';

    private ?Province $province;
    private ?Town $town;
    private Fuel $fuel;
    private ServiceType $serviceType;
    private SalesType $salesType;

    /** Alongside $to, represents a bounding box used to restrict the results to only the area inside. */
    private ?Location $from;

    /** Alongside $from, represents a bounding box used to restrict the results to only the area inside. */
    private ?Location $to;

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
    public function province(Province $province): StationDetailsBuilder
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
    public function town(Town $town): StationDetailsBuilder
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
    public function fuel(Fuel $fuel): StationDetailsBuilder
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
    public function serviceType(ServiceType $serviceType): StationDetailsBuilder
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
    public function salesType(SalesType $salesType): StationDetailsBuilder
    {
        $this->salesType = $salesType;
        return $this;
    }

    /**
     * Sets the "from" geographical point used to create a bounding box to further restrict the results retrieved.
     *
     * Does not make effect if "to" is not set.
     *
     * @param float $latitude
     * @param float $longitude
     * @return $this
     */
    public function from(float $latitude, float $longitude): StationDetailsBuilder
    {
        $this->from = new Location($latitude, $longitude);
        return $this;
    }

    /**
     * Sets the "to" geographical point used to create a bounding box to further restrict the results retrieved.
     *
     * Does not make effect if "from" is not set.
     *
     * @param float $latitude
     * @param float $longitude
     * @return $this
     */
    public function to(float $latitude, float $longitude): StationDetailsBuilder
    {
        $this->to = new Location($latitude, $longitude);
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
        $parameters = [
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
        ];

        if (isset($this->from, $this->to)) {
            $parameters['x0'] = $this->from->latitude;
            $parameters['y0'] = $this->from->longitude;
            $parameters['x1'] = $this->from->latitude;
            $parameters['y1'] = $this->from->longitude;
        }

        return json_encode($parameters);
    }

    /**
     * Converts the output json object provided by the API to a GasStationLocation instance.
     *
     * @param stdClass $jsonObject
     * @return GasStation
     */
    private function jsonObjectToDto(stdClass $jsonObject): GasStation
    {
        $station = new GasStation;

        $station->id = $jsonObject->id;
        $station->location = new Location($jsonObject->coordenadaX_dec, $jsonObject->coordenadaY_dec);
        $station->price = $jsonObject->precio;
        $station->owner = $jsonObject->precio;

        $station->address = new Address(
            $jsonObject->address,
            new Town($jsonObject->localidad),
            new Province($jsonObject->provincia),
            $jsonObject->codPostal
        );

        $station->salesType = new SalesType($jsonObject->tipoVenta);

        $station->location = new Location($jsonObject->coordenadaY_dec, $jsonObject->coordenadaX_dec);

        $station->bioethanolPercentage = $jsonObject->porcBioetanol;
        $station->bioalcoholPercentage = $jsonObject->porcBioalcohol;

        $station->hasCarWash = $jsonObject->servicios->lavado;
        $station->hasWaterAir = $jsonObject->servicios->aguaAire;
        $station->hasStore = $jsonObject->servicios->tienda;
        $station->hasCoffeeShop = $jsonObject->servicios->cafeteria;

        $station->schedule = $jsonObject->horario;

        $station->averageRating = $jsonObject->valoracion->valoracionMedia;
        $station->numberRating = $jsonObject->valoracion->valoracionMedia;

        return $station;
    }
}
