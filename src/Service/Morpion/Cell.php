<?php

namespace App\Service\Morpion;

class Cell
{
    private ?bool $symbol = null;
    private int $xPos;
    private int $yPos;

    public function __equals(Cell $otherCell)
    {
        return $this->symbol === $otherCell->getSymbol();
    }

    public function getSymbol(): ?bool
    {
        return $this->symbol;
    }

    public function setSymbol(?bool $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getXPos(): int
    {
        return $this->xPos;
    }

    public function setXPos(int $xPos): self
    {
        $this->xPos = $xPos;

        return $this;
    }

    public function getYPos(): int
    {
        return $this->yPos;
    }

    public function setYPos(int $yPos): self
    {
        $this->yPos = $yPos;

        return $this;
    }
}
