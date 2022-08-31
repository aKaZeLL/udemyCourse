<?php

namespace App\Controller;

use App\Form\DishType;
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
	public function create(Request $request, ManagerRegistry $doctrine): Response
	{
		$dish = new Dishes();
		$form = $this->createForm(DishType::class, $dish);
		$form->handleRequest($request);
		
		if ($form->isSubmitted()) {
			//entity manager
			$em = $doctrine->getManager();
			
			$em->persist($dish);
			$em->flush();
			
			return $this->redirect($this->generateUrl('app_dishes.edit'));
		}
		
		
		return $this->render('dishes/create.html.twig', [
            'dishForm' => $form->createView()
        ]);
	}
	
	#[Route('/remove/{id}', name: 'remove')]
	public function remove($id, DishesRepository $dr, ManagerRegistry $doctrine) 
	{
		$toDelete = $dr->find($id);
		
		//entity manager
		$em = $doctrine->getManager();
		
		$em->remove($toDelete);
		$em->flush();
		
		//Message
		$this->addFlash('success', 'Elemento eliminato correttamente');
		
		return $this->redirect($this->generateUrl('app_dishes.edit'));
	}
}
