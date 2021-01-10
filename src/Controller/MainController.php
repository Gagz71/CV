<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Recaptcha\RecaptchaValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
	/**
	* @Route("/", name="main")
	*/
	public function index(Request $request, RecaptchaValidator $recaptchaValidator): Response
	{
		$form = $this->createForm(ContactFormType::class);
		$form->handleRequest($request);

		// Vérification que le formulaire a bien été soumis
		if($form->isSubmitted()){
			//Si le recaptcha n'a pas été validé
			if(!$recaptchaValidator->verify( $request->request->get('g-recaptcha-response'), $request->server->get('REMOTE_ADDR') )){
				// Ajout d'une nouvelle erreur manuellement dans le formulaire
				$form->addError(new FormError('Le Captcha doit être validé !'));
			}

			if($form->isValid()){

				//Envoie d'un mail à mon mail pour me prévenir

				// Création d'un flash message de type "success"
				$this->addFlash('success', 'Votre message a bien été envoyé  ! Je fais le nécessaire afin de vous répondre dans les plus brefs délais !');

			}

		}


		return $this->render('main/index.html.twig', [
			'form' => $form->createView()
		]);
	}
}
