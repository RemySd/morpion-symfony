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
                if (!empty($cell->getSymbol)) {
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
        if ($this->cells[0][0] === $this->cells[0][1] && $this->cells[0][0] == $this->cells[0][2]) {
            return $this->cells[0][0]->getSymbol();
        }

        if ($this->cells[1][0] === $this->cells[1][1] && $this->cells[0][0] == $this->cells[1][2]) {
            return $this->cells[1][0]->getSymbol();
        }

        if ($this->cells[2][0] === $this->cells[2][1] && $this->cells[2][0] == $this->cells[2][2]) {
            return $this->cells[2][0]->getSymbol();
        }

        if ($this->cells[0][0] === $this->cells[1][0] && $this->cells[0][0] == $this->cells[2][0]) {
            return $this->cells[0][0]->getSymbol();
        }
        
        if ($this->cells[0][1] === $this->cells[1][1] && $this->cells[0][1] == $this->cells[2][1]) {
            return $this->cells[0][1]->getSymbol();
        }

        if ($this->cells[0][2] === $this->cells[1][2] && $this->cells[0][2] == $this->cells[2][2]) {
            return $this->cells[0][2]->getSymbol();
        }

        if ($this->cells[0][0] === $this->cells[1][1] && $this->cells[0][0] == $this->cells[2][2]) {
            return $this->cells[0][0]->getSymbol();
        }

        if ($this->cells[2][0] === $this->cells[1][1] && $this->cells[2][0] == $this->cells[0][2]) {
            return $this->cells[2][0]->getSymbol();
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
