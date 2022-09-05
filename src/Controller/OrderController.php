<?php

namespace App\Controller;

use App\Entity\Dishes;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class OrderController extends AbstractController
{
    #[Route('/ordination', name: 'app_ordination')]
    public function index(OrderRepository $orderRep): Response
    {
		$order = $orderRep->findBy(
			['tableId' => 'Tavolo1']
		);
		
        return $this->render('order/index.html.twig', [
            'orders' => $order,
        ]);
    }

    #[Route('/order/{id}', name: 'app_order')]	
	public function order(Dishes $dish, ManagerRegistry $doctrine)
	{
		$order = new Order();
		$order->settableId('Tavolo1');
		$order->setName($dish->getName());
		$order->setOrderNumber($dish->getId());
		$order->setPrice($dish->getPrice());
		$order->setStatus('aperta');
		
		$em = $doctrine->getManager();
		$em->persist($order);
		$em->flush();

		$this->addFlash('order', $order->getName().': ordine inserito correttamente.');

		return $this->redirect($this->generateUrl('app_menu'));
	}
	
	 /**
     * @Route("/status/{id},{status}", name="status")
     */
    public function status($id, $status, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $order = $em->getRepository(Order::class)->find($id);

        $order->setStatus($status);
        $em->flush();

        return $this->redirect($this->generateUrl('app_ordination'));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id, OrderRepository $or, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $order = $or->find($id);
        $em->remove($order);
        $em->flush();

        return $this->redirect($this->generateUrl('app_ordination'));
    }
}
