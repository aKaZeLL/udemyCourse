<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): Response
    {
		$regForm = $this->createFormBuilder()
			->add('username', TextType::class, [
				'label'=>'Nome Utente'])
			->add('password', RepeatedType::class, [
				'type'=>PasswordType::class,
				'required'=>true,
				'first_options'=>['label'=>'Password'],
				'second_options'=>['label'=>'Ripeti Password'],
			])
			->add('Registrati', SubmitType::class)
			->getForm();
		
		$regForm->handleRequest($request);
		
		if ($regForm->isSubmitted()) {
			$input = $regForm->getData();
			
			$user = new User();
			$user->setUsername($input['username']);
			
			$hashedPassword = $passwordHasher->hashPassword($user, $input['password']);
			$user->setPassword($hashedPassword);
			
			$em = $doctrine->getManager();
			$em->persist($user);
			$em->flush();
			
			return $this->redirect($this->generateUrl('app_login'));
		}
		
        return $this->render('registration/index.html.twig', [
            'regForm' => $regForm->createView()
        ]);
    }
}
