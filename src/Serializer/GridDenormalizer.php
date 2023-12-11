<?php

namespace App\Serializer;

use App\Service\Morpion\Cell;
use App\Service\Morpion\Grid;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;

class GridDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, $type, $format = null, array $context = [])
    {
        $cells = [];

        foreach ($data['cells'] as $cellLine) {
            $line = [];
            foreach ($cellLine as $cell) {
                $cell = $this->denormalizer->denormalize($cell, Cell::class, $format, $context);
                $line[] = $cell;
            }
            
            $cells[] = $line;
        }
        
        $data['cells'] = $cells;

        dump($data);
        $this->denormalizer->denormalize($data, $type, $format, $context);
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return false;
        if ($type === Grid::class && !empty($data)) {
            $firstCell = $data['cells'][0][0];
            if (!$firstCell instanceof Cell) {
                dump('?');
                return true;
            }
        }

        return false;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Grid::class => true
        ];
    }
}
