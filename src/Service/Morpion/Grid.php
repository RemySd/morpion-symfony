<?php

namespace App\Service\Morpion;

use App\Service\Morpion\Cell;

class Grid
{
    private ?string $playerTurn = null;
    private array $cells = [];

    public function getCells(): array
    {
        return $this->cells;
    }

    public function setCells(array $cells): self
    {
        $this->cells = $cells;

        return $this;
    }

    public function getPlayerTurn(): string
    {
        return $this->playerTurn;
    }

    public function setPlayerTurn(?string $turn): self
    {
        $this->playerTurn = $turn;

        return $this;
    }

    public function getCellByPosition(int $yPos, int $xPos): Cell
    {
        return $this->cells[$xPos][$yPos];
    }

    public function isOver(): bool
    {
        $countCellsWithSymbol = 0;

        foreach ($this->cells as $cellLine) {
            foreach ($cellLine as $cell) {
                if (!empty($cell->getSymbol())) {
                    $countCellsWithSymbol++;
                }
            }
        }

        if ($countCellsWithSymbol === 9) {
            return true;
        }

        return false;
    }

    public function getWinner(): ?string
    {
        $bottomLeft = $this->getCellByPosition(0, 0)->getSymbol();
        $left = $this->getCellByPosition(1, 0)->getSymbol();
        $topLeft = $this->getCellByPosition(2, 0)->getSymbol();
        $top = $this->getCellByPosition(2, 1)->getSymbol();
        $topRight = $this->getCellByPosition(2, 2)->getSymbol();
        $right = $this->getCellByPosition(1, 2)->getSymbol();
        $bottomRight = $this->getCellByPosition(0, 2)->getSymbol();
        $bottom = $this->getCellByPosition(0, 1)->getSymbol();
        $center = $this->getCellByPosition(1, 1)->getSymbol();

        if ($bottomLeft === $bottom && $bottomLeft == $bottomRight && !empty($bottomLeft)) {
            return $bottomLeft;
        }

        if ($left === $center && $left === $right && !empty($left)) {
            return $left;
        }

        if ($topLeft === $top && $topLeft === $topRight && !empty($topLeft)) {
            return $topLeft;
        }

        if ($bottomLeft === $left && $bottomLeft === $topLeft && !empty($bottomLeft)) {
            return $bottomLeft;
        }
        
        if ($bottom === $center && $bottom === $top && !empty($bottom)) {
            return $bottom;
        }

        if ($bottomRight === $right && $bottomRight === $topRight && !empty($bottomRight)) {
            return $bottomRight;
        }

        if ($bottomLeft === $center && $bottomLeft === $topRight && !empty($bottomLeft)) {
            return $bottomLeft;
        }

        if ($topLeft === $center && $topLeft === $bottomRight && !empty($topLeft)) {
            return $topLeft;
        }

        return null;
    }

    public function hasWinner(): bool
    {
        return !empty($this->getWinner()) ? true : false;
    }
}
