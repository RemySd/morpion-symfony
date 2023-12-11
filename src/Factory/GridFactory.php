<?php

namespace App\Factory;

use App\Service\Morpion\Cell;
use App\Service\Morpion\Grid;
use App\Factory\FactoryInterface;
use App\Service\Morpion\MorpionManager;

class GridFactory implements FactoryInterface
{
    public function build(?array $parameters = null)
    {
        $grid = new Grid();
        $playerTurn = rand(0, 1) ? MorpionManager::CROSS_PLAYER : MorpionManager::CIRCLE_PLAYER;
        $grid->setPlayerTurn($playerTurn);

        $cells = [];

        for ($y = 2; $y >= 0; $y--) {
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
