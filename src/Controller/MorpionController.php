<?php

namespace App\Controller;

use App\Service\Morpion\MorpionManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MorpionController extends AbstractController
{
    private MorpionManager $morpionMananger;

    public function __construct(MorpionManager $morpionMananger)
    {
        $this->morpionMananger = $morpionMananger;
    }

    #[Route('/edit-locale/{locale}', name: 'app_morpion_edit_locale')]
    public function editLocale(string $locale, Request $request): Response
    {
        $request->getSession()->set('_locale', $locale);
        $route = $request->headers->get('referer', 'app_memory');

        return $this->redirect($route);
    }

    #[Route('/', name: 'app_morpion')]
    public function index(): Response
    {
        return $this->render('morpion/index.html.twig');
    }

    #[Route('/initialize', name: 'app_morpion_initialize')]
    public function initialization(): Response
    {
        $this->morpionMananger->saveGrid($this->morpionMananger->initializeGrid());

        return $this->redirectToRoute('app_morpion_play');
    }

    #[Route('/play', name: 'app_morpion_play')]
    public function play(Request $request): Response
    {
        $grid = $this->morpionMananger->getGrid();
        $cellPositions = $this->morpionMananger->getInteractedCellPositions();

        if (!empty($cellPositions)) {
            $this->morpionMananger->applySymbolToCell($grid, $cellPositions);
            $this->morpionMananger->updatePlayerTurn($grid);
            $this->morpionMananger->saveGrid($grid);
        }

        return $this->render('morpion/play.html.twig', [
            'grid' => $grid
        ]);
    }
}
