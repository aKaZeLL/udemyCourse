<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DishesRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(DishesRepository $dr): Response
    {
		$allDishes = $dr->findAll();
		
		$random = array_rand($allDishes, 2);
		
        return $this->render('home/index.html.twig', [
            'dish1' => $allDishes[$random[0]],
			'dish2' => $allDishes[$random[1]],
        ]);
    }
}
