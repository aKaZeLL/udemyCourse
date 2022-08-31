<?php

namespace App\Controller;

use App\Entity\Dishes;
use App\Repository\DishesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

    #[Route('/dishes', name: 'app_dishes.')]
class DishesController extends AbstractController
{
    #[Route('/', name: 'edit')]
    public function index(DishesRepository $dr): Response
    {
		$allDishes = $dr->findAll();

        return $this->render('dishes/index.html.twig', [
            'dishes' => $allDishes
        ]);
    }
	
	#[Route('/create', name: 'create')]
	public function create(Request $request, ManagerRegistry $doctrine): Response {
		$dishes = new Dishes();
		$dishes->setName('Pizza');
		
		//entity manager
		$em = $doctrine->getManager();
		
		$em->persist($dishes);
		$em->flush();
		
		return new Response('Pietanza Creata');
	}
	
}
