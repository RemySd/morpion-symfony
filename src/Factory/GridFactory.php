<?php

namespace App\Service\Morpion;

use App\Factory\FactoryInterface;

class GridFactory implements FactoryInterface
{
    public function build(?array $parameters = null)
    {
        $grid = new Grid();
        $cells = [];

        for ($y = 0; $y < 3; $y++) {
            $cellLine = [];

            for ($x = 0; $x < 3; $x++) {
                $cell = new Cell();
                $cell->setXPos($x);
                $cell->setYPos($y);

                $cellLine[$x] = $cell;
            }

            $cells[$y] = $cellLine;
        }

        $grid->setCells($cells);

        return $grid;
    }
}
