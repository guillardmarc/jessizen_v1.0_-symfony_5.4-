<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class ContactUsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ici votre nom et prénom'
                ],
                'label' => 'Nom / Prénom',
                'mapped' => false,
                'required' => True,
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Ici votre email'
                ],
                'mapped' => false,
                'required' => true,
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Ici votre message',
                ],
                'label' => 'Message',
                'mapped'=> False,
                'required' => True,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'constraints' => [
                    new IsTrue([
                        'message'=>'Vous devez accepter l\'envoie de vos données saissies'
                    ]),
                ],
                'label' => 'J\'accepte l\'envoie de mes données',
                'mapped' => False,
                'required' => True,
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'autocomplete'=>'disabled',
                    'class'=>'visually-hidden',
                    'placeholder'=>'Ville',
                ],
                'label' => False,
                'mapped' => False,
                'required' => False,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
