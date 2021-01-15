<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
					]),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' =>  'Votre nom doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Votre nom doit contenir au moins {{ limit }} caractères',
                    ])
				]
		        ])
		        ->add('firstName', TextType::class, [
		                'label' => 'Prénom',
			        'constraints' => [
				        new NotBlank([
					        'message' => 'Merci de renseigner votre prénom'
				        ]),
                        new Length([
                            'min' => 2,
                            'max' => 50,
                            'minMessage' =>  'Votre nom doit contenir au moins {{ limit }} caractères',
                            'maxMessage' => 'Votre nom doit contenir au moins {{ limit }} caractères',
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
			->add('agreeTerms', CheckboxType::class, [
				'label' => 'En soumettant ce formulaire, j\'accepte que les informations saisies soient exploitées dans le cadre de la demande de contact et de la relation commerciale qui peut en découler',
				'constraints' => [
					new NotBlank([
						'message' => 'Merci de renseigner un message'
					]),
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
