<?php

namespace Flerex\SpainGas\QueryBuilders;

use DateTime;
use Flerex\SpainGas\Contracts\QueryBuilders\StationDetailsBuilder as StationDetailsBuilderContract;
use Flerex\SpainGas\Dtos\Address;
use Flerex\SpainGas\Dtos\GasStation;
use Flerex\SpainGas\Dtos\Location;
use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\ServiceType;
use Flerex\SpainGas\Exceptions\LogicException;
use Flerex\SpainGas\Exceptions\NetworkException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class StationDetailsBuilder implements StationDetailsBuilderContract
{
    private const API_ENDPOINT_URL = 'https://geoportalgasolineras.es/rest/busquedaEstacionesInfo';

    private ?Province $province;
    private ?int $town;
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

    /** @inheritDoc */
    public function province(Province $province): StationDetailsBuilderContract
    {
        $this->province = $province;
        return $this;
    }

    /** @inheritDoc */
    public function town(int $town): StationDetailsBuilderContract
    {
        $this->town = $town;
        return $this;
    }

    /** @inheritDoc */
    public function fuel(Fuel $fuel): StationDetailsBuilderContract
    {
        $this->fuel = $fuel;
        return $this;
    }

    /** @inheritDoc */
    public function serviceType(ServiceType $serviceType): StationDetailsBuilderContract
    {
        $this->serviceType = $serviceType;
        return $this;
    }

    /** @inheritDoc */
    public function salesType(SalesType $salesType): StationDetailsBuilderContract
    {
        $this->salesType = $salesType;
        return $this;
    }

    /** @inheritDoc */
    public function from(float $latitude, float $longitude): StationDetailsBuilderContract
    {
        $this->from = new Location($latitude, $longitude);
        return $this;
    }

    /** @inheritDoc */
    public function to(float $latitude, float $longitude): StationDetailsBuilderContract
    {
        $this->to = new Location($latitude, $longitude);
        return $this;
    }

    /** @inheritDoc */
    public function get(): array
    {
        $client = new GuzzleClient;

        try {
            $body = $this->toJson();
            $response = $client->post(static::API_ENDPOINT_URL, compact('body'));


            $data = simplexml_load_string($response->getBody()->getContents());

            if ($data === false) {
                throw new LogicException("Could not parse the response.");
            }

            if ($data->count() == 0) {
                return [];
            }


            // Access "estaciones" tag directly to prevent it from being converted to an object
            // instead of an array when it contains only one element.
            $data = json_decode(json_encode($data->xpath("//estaciones")));


            return array_map(fn($s) => $this->jsonObjectToDto($s), $data);
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
            'idProvincia' => $this->province,
            'idMunicipio' => $this->town,
            'idProducto' => $this->fuel->getValue(),
            'rotulo' => '',
            'eessEconomicas' => false,
            'conPlanesDescuento' => false,
            'horarioInicial' => null,
            'horarioFinal' => null,
            'calle' => null,
            'numero' => null,
            'codPostal' => null,
            'tipoVenta' => $this->salesType->getValue(),
            'tipoServicio' => $this->serviceType->getValue(),
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

        $station->id = $jsonObject->estacion->id;
        $station->label = $jsonObject->estacion->rotulo;

        $station->price = is_numeric($jsonObject->precio) ? $jsonObject->precio : null;

        $station->priceLastUpdatedAt = DateTime::createFromFormat(
            'd/m/Y H:i',
            "{$jsonObject->estacion->fechaPvp} {$jsonObject->estacion->horaPvp}"
        );
        $station->owner = $jsonObject->estacion->operador;

        $station->address = new Address(
            trim($jsonObject->estacion->direccion),
            trim($jsonObject->estacion->localidad),
            trim($jsonObject->estacion->provincia),
            trim($jsonObject->estacion->codPostal)
        );

        $station->salesType = new SalesType($jsonObject->estacion->tipoVenta);

        $station->location = new Location(
            $jsonObject->estacion->coordenadaY_dec, $jsonObject->estacion->coordenadaX_dec
        );

        $station->bioethanolPercentage = $jsonObject->estacion->porcBioetanol;
        $station->bioalcoholPercentage = $jsonObject->estacion->porcBioalcohol;

        $station->hasCarWash = $jsonObject->estacion->servicios->lavado;
        $station->hasWaterAir = $jsonObject->estacion->servicios->aguaAire;
        $station->hasStore = $jsonObject->estacion->servicios->tienda;
        $station->hasCoffeeShop = $jsonObject->estacion->servicios->cafeteria;

        $station->schedule = $jsonObject->estacion->horario;

        $station->averageRating = $jsonObject->estacion->valoracion->valoracionMedia;
        $station->numberRating = $jsonObject->estacion->valoracion->valoracionMedia;

        return $station;
    }
}
