<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Websites;
use App\Entity\WebsitesUpdates;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebsitesUpdatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr'=>[
                    'placeholder' => 'Ici le titre de la mise à jour'
                ],
                'label'=>'Titre*',
                'required'=>true,
            ])
            ->add('date', DateType::class, [
                'label'=>'Date de mise à jour*',
                'widget'=>'single_text',
                'required'=>true,
            ])
            ->add('moreInfo', CKEditorType::class, [
                'config'=>array(
                    'editorplaceholder'=>'Ici la description de la mise à jour'
                ),
                'label'=>'Description',
                'required'=>false,
            ])
            // ->add('underVersion', TextType::class, [
            //     'attr'=>[
            //         'placeholder'=>'Ici la sous version du site après la mise à jour',
            //     ],
            //     'label'=>'Sous version*',
            //     'required'=>true
            // ])
            ->add('website', EntityType::class, [
                'class' => Websites::class,
                'choice_label'=>'version',
                'label' => 'Version du site*',
                'placeholder'=>'Selectionner la version du site',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WebsitesUpdates::class,
        ]);
    }
}
