<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Recaptcha\RecaptchaValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
	/**
	* @Route("/", name="main")
	*/
	public function index(Request $request, RecaptchaValidator $recaptchaValidator, MailerInterface $mailer): Response
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

				$contactLastname = $form->get('lastName')->getData();
				$contactFirstname = $form->get('firstName')->getData();
				$contactEmail = $form->get('email')->getData();
				$contactSubject = $form->get('subject')->getData();
				$contactContent = $form->get('content')->getData();

				$contentEmailToSend = '<h1 class="font-helvetica-med">As salamou \'aleikoum</h1>
                                            <p class="font-helvetica-thin">Tu as reçu un message sur ton site de la part de: 
                                            <ul>
                                            <li>Nom : '.$contactLastname.' </li>
                                            <li>Prénom: '.$contactFirstname.'</li>
                                            <li>Email: '.$contactEmail.'</li>
                                            <li>Sujet du message: '.$contactSubject.'</li>
                                            </ul>
                                            </p>';
				$contentEmailToSend .= '<p class="font-helvetica-med">Le message: </p><p class="font-helvetica-thin"> '.$contactContent.'</p>';

				//Envoie d'un mail à mon mail pour me prévenir
				$email = (new Email())
					->from(new Address('contact@dounia-manhouli.fr', 'dounia-manhouli.fr'))
					->to('sangodoun@protonmail.com')
					->cc('contact@dounia-manhouli.fr')
					//->bcc('bcc@example.com')
					//->replyTo('fabien@example.com')
					//->priority(Email::PRIORITY_HIGH)
					->subject('Demande de contacte sur dounia-manhouli.fr')
					->text('Sending emails is fun again!')
					->html($contentEmailToSend);

				$mailer->send($email);


				// Création d'un flash message de type "success"
				$this->addFlash('success', 'Votre message a bien été envoyé  ! Je fais le nécessaire afin de vous répondre dans les plus brefs délais !');

				//redirection vers le haut du formulaire
				$this->redirect('/#form-contact');

			}

		}


		return $this->render('main/index.html.twig', [
			'form' => $form->createView()
		]);
	}
}
