<?php

namespace Flerex\SpainGas\Dtos;


final class Town
{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }
}
