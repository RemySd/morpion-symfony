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

    public function getCellByPosition(int $xPos, int $yPos): Cell
    {
        return $this->cells[$yPos][$xPos];
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
        $bottomLeft = $this->cells[0][0]->getSymbol();
        $left = $this->cells[1][0]->getSymbol();
        $topLeft = $this->cells[2][0]->getSymbol();
        $top = $this->cells[2][1]->getSymbol();
        $topRight = $this->cells[2][2]->getSymbol();
        $right = $this->cells[1][2]->getSymbol();
        $bottomRight = $this->cells[0][2]->getSymbol();
        $bottom = $this->cells[0][1]->getSymbol();
        $center = $this->cells[1][1]->getSymbol();

        if ($bottomLeft === $bottom && $bottomLeft == $bottomRight) {
            return $bottomLeft;
        }

        if ($left === $center && $left == $right) {
            return $left;
        }

        if ($topLeft === $top && $topLeft == $topRight) {
            return $topLeft;
        }

        if ($bottomLeft === $left && $bottomLeft == $bottomRight) {
            return $bottomLeft;
        }
        
        if ($bottom === $center && $bottom == $top) {
            return $bottom;
        }

        if ($bottomRight === $right && $bottomRight == $topRight) {
            return $bottomRight;
        }

        if ($bottomLeft === $center && $bottomLeft == $topRight) {
            return $bottomLeft;
        }

        if ($topLeft === $center && $topLeft == $bottomRight) {
            return $topLeft;
        }

        return null;
    }

    public function hasWinner(): bool
    {
        return !empty($this->getWinner()) ? true : false;
    }

    //public function getAdjacentCell(Cell $cell, array $cellsToExclude): array
    //{
    //    $adjacentsCells = [];
//
    //    $xPos = $cell->getXPos();
    //    $yPos = $cell->getYPos();
//
    //    if (!empty($this->cells[$yPos - 1][$xPos])) {
    //        $adjacentsCells[] = $this->cells[$yPos - 1][$xPos];
    //    }
//
    //    if (!empty($this->cells[$yPos + 1][$xPos])) {
    //        $adjacentsCells[] = $this->cells[$yPos + 1][$xPos];
    //    }
//
    //    if (!empty($this->cells[$yPos][$xPos - 1])) {
    //        $adjacentsCells[] = $this->cells[$yPos][$xPos - 1];
    //    }
//
    //    if (!empty($this->cells[$yPos][$xPos + 1])) {
    //        $adjacentsCells[] = $this->cells[$yPos][$xPos + 1];
    //    }
//
    //    return $adjacentsCells;
    //}
}
