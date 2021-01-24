<?php

namespace Flerex\SpainGas\Dtos;

use Flerex\SpainGas\Enums\Province;

final class Product
{
    public ?int $id;
    public ?string $name;
    public ?string $description;
    public ?bool $active;
    public bool $terrestrial;
    public bool $boat;
    public bool $bioethanol;
    public bool $biodiesel;
    public ?int $order;
}
