<?php

namespace Flerex\SpainGas\Dtos;

use Flerex\SpainGas\Enums\SalesType;

final class GasStation
{
    public int $id;
    public string $label;
    public float $price;
    public string $owner;

    public ?Address $address;

    public SalesType $salesType;

    public Location $location;

    public float $bioethanolPercentage;
    public float $bioalcoholPercentage;

    public bool $hasCarWash;
    public bool $hasWaterAir;
    public bool $hasStore;
    public bool $hasCoffeeShop;

    public string $schedule;

    public float $averageRating;
    public int $numberRating;
}
