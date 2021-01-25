<?php

namespace Flerex\SpainGas\Dtos;

use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\Town;

final class Address
{
    public float $line;
    public string $town;
    public Province $province;
    public string $postalCode;

    public function __construct(float $line, string $town, Province $province, string $postalCode) {
        $this->line = $line;
        $this->town = $town;
        $this->province = $province;
        $this->postalCode = $postalCode;
    }
}
