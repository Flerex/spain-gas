<?php

include 'vendor/autoload.php';

use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\GasApi;

$stations = GasApi::gasStations()
    ->province(Province::A_CORUNA())
    ->fuel(Fuel::CNG())
    ->get();

var_dump($stations);