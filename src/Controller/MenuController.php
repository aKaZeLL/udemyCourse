<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DishesRepository;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]
    public function menu(DishesRepository $dr): Response
    {
		$allDishes = $dr->findAll();
		
        return $this->render('menu/index.html.twig', [
            'dishes' => $allDishes,
        ]);
    }
}
