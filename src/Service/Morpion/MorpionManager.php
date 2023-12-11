<?php

namespace App\Service\Morpion;

use App\Service\Morpion\Grid;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class MorpionManager
{
    public const MORPION_SESSION_KEY = 'grid_morpion';

    private SerializerInterface $serializer;
    private RequestStack $requestStack;
    private ObjectNormalizer $objectNormalizer;

    public function __construct(SerializerInterface $serializer, RequestStack $requestStack, ObjectNormalizer $objectNormalizer)
    {
        $this->serializer = $serializer;
        $this->requestStack = $requestStack;
        $this->objectNormalizer = $objectNormalizer;
    }

    public function initializeGrid(): Grid
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

    public function saveGrid(Grid $grid): void
    {
        $jsonGrid = $this->serializer->serialize($grid, 'json');
        $this->requestStack->getSession()->set(self::MORPION_SESSION_KEY, $jsonGrid);
    }

    public function getGrid(): Grid
    {
        dump('ok');
        $jsonGrid = $this->requestStack->getSession()->get(self::MORPION_SESSION_KEY);
        $grid = $this->serializer->deserialize($jsonGrid, Grid::class, 'json');

        $newCells = [];

        foreach ($grid->getCells() as $cellLine) {
            $newCellLine = [];

            foreach ($cellLine as $cell) {
                $cell = $this->objectNormalizer->denormalize($cell, Cell::class, 'json');
                $newCellLine[] = $cell;
            }

            $newCells[] = $newCellLine;
        }

        $grid->setCells($newCells);
        dump($grid);

        return $grid;
    }
}
