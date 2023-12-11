<?php

namespace App\Service\Morpion;

use App\Factory\GridFactory;
use App\Service\Morpion\Grid;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\SerializerInterface;

class MorpionManager
{
    private const MORPION_SESSION_KEY = 'grid_morpion';

    public const CIRCLE_PLAYER = 'circle';
    public const CROSS_PLAYER = 'cross';

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

    public function getInteractedCellPositions(): ?array
    {
        $cellPosition = $this->requestStack->getCurrentRequest()->query->get('cell', null);

        if (!empty($cellPosition)) {
            return explode('-', $cellPosition);
        }

        return null;
    }

    public function updatePlayerTurn(Grid $grid): void
    {
        if ($grid->getPlayerTurn() === MorpionManager::CIRCLE_PLAYER) {
            $grid->setPlayerTurn(MorpionManager::CROSS_PLAYER);
        } else {
            $grid->setPlayerTurn(MorpionManager::CIRCLE_PLAYER);
        }
    }

    public function applySymbolToCell(Grid $grid, array $positions): void
    {
        $cell = $grid->getCellByPosition($positions[0], $positions[1]);
        $cell->setSymbol($grid->getPlayerTurn());
    }
}
