<?php

namespace Flerex\SpainGas\Dtos;

final class DegreesLocation
{
    public DegreesCoordinate $latitude;
    public DegreesCoordinate $longitude;

    public function __construct(float $latitude, float $longitude)
    {
       $this->latitude = new DegreesCoordinate($latitude, 'N', 'S');
       $this->longitude = new DegreesCoordinate($longitude, 'E', 'W');
    }
}
