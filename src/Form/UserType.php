<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Ici votre nouvelle email',
                ],
                'label' => 'Email',
                'required' => true,
            ])
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ici votre pseudo',
                ],
                'label' => 'Pseudo',
                'required' => true,
            ])
            ->add('picture', FileType::class, [
                'attr' => [
                    'placeholder' => 'Selectionnerv                                             votre image',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Veuillez entrer un format de document valide',
                    ])
                ],
                'label' => "Image",
                'mapped' => false,
                'required' => false,
            ])
            ->add('birthday', BirthdayType::class, [
                'placeholder' => 'Select a value',
                'label' => 'Date de naissance',
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('moreInfo', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Ici quelque infos sur vous',
                ],
                'label' => 'Plus d\'info',
                'mapped' => true,
                'required' => false,
            ])
            ->add('link', UrlType::class, [
                'attr' => [
                    'placeholder' => 'Ici votre lien'
                ],
                'label' => 'Lien',
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
