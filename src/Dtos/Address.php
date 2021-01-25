<?php

namespace Flerex\SpainGas\Dtos;

use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\Town;

final class Address
{
    public string $line;
    public string $town;
    public string $province;
    public string $postalCode;

    public function __construct(string $line, string $town, string $province, string $postalCode) {
        $this->line = $line;
        $this->town = $town;
        $this->province = $province;
        $this->postalCode = $postalCode;
    }
}
