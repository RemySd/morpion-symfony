<?php

namespace App\Serializer;

use App\Service\Morpion\Cell;
use App\Service\Morpion\Grid;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class GridDenormalizer implements DenormalizerInterface
{
    private ObjectNormalizer $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        /**
         * @var Grid $grid
         */
        $grid = $this->normalizer->denormalize($data, Grid::class, $format, $context);

        $newCells = [];

        foreach ($grid->getCells() as $cellLine) {
            $newCellLine = [];

            foreach ($cellLine as $cell) {
                $cell = $this->normalizer->denormalize($cell, Cell::class, 'json');
                $newCellLine[] = $cell;
            }

            $newCells[] = $newCellLine;
        }

        $grid->setCells($newCells);

        return $grid;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null /* , array $context = [] */): bool
    {
        return (is_array($data) && array_key_exists('cells', $data));
    }
}
