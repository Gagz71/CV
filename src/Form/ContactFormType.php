<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('lastName', TextType::class, [
		                'label' => 'Nom',
				'constraints' => [
					new NotBlank([
						'message' => 'Merci de renseigner votre nom'
					])
				]
		        ])
		        ->add('firstName', TextType::class, [
		                'label' => 'Prénom',
			        'constraints' => [
				        new NotBlank([
					        'message' => 'Merci de renseigner votre prénom'
				        ])
			        ]
		        ])
			->add('email', EmailType::class, [
				'label' => 'Email',
				'constraints' => [
					new Email([
						'message' => 'L\'adresse email {{value}} n\'est pas une adresse mail valide'
					]),
					new NotBlank([
						'message' => 'Merci de renseigner une adresse email'
					])
				]
			])
			->add('subject', TextType::class, [
				'label' => 'Sujet',
				'constraints' => [
					new Length([
						'min' => 2,
						'max' => 150,
						'minMessage' => 'Le sujet doit contenir au moins {{ limit }} caractères',
						'maxMessage' => 'Le sujet doit contenir au maximum {{ limit }} caractères'
					])
				]
			])
			->add('content', TextareaType::class, [
				'label' => 'Message',
				'constraints' => [
					new NotBlank([
						'message' => 'Merci de renseigner un message'
					]),
					new Length([
						'min' => 2,
						'max' => 20000,
						'minMessage' => 'Le contenu doit contenir au moins {{ limit }} caractères',
						'maxMessage' => 'Le contenu doit contenir au maximum {{ limit }} caractères',
					])
				]
			])
			->add('submit', SubmitType::class, [
				'label' => 'J\'envoie',
				'attr' => [
					'class' => 'btn-grad'
				]
			])

		;
	}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
