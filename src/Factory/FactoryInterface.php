<?php

namespace App\Factory;

interface FactoryInterface
{
    public function build(?array $parameters = null);
}
