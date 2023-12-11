<?php

namespace App\Service\Morpion;

use App\Service\Morpion\Grid;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\SerializerInterface;

class MorpionManager
{
    public const MORPION_SESSION_KEY = 'grid_morpion';

    private SerializerInterface $serializer;
    private RequestStack $requestStack;
    private GridFactory $gridFactory;

    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        GridFactory $gridFactory
    ) {
        $this->serializer = $serializer;
        $this->requestStack = $requestStack;
        $this->gridFactory = $gridFactory;
    }

    public function initializeGrid(): Grid
    {
        return $this->gridFactory->build();
    }

    public function saveGrid(Grid $grid): void
    {
        $jsonGrid = $this->serializer->serialize($grid, 'json');
        $this->requestStack->getSession()->set(self::MORPION_SESSION_KEY, $jsonGrid);
    }

    public function getGrid(): Grid
    {
        $jsonGrid = $this->requestStack->getSession()->get(self::MORPION_SESSION_KEY);
        $grid = $this->serializer->deserialize($jsonGrid, Grid::class, 'json');

        return $grid;
    }

    public function getInteractedCell(): ?array
    {
        $cellPosition = $this->requestStack->getCurrentRequest()->query->get('cell', null);

        if (!empty($cellPosition)) {
            return explode('-', $cellPosition);
        }

        return null;
    }
}
