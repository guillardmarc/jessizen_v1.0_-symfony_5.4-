<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\UX\Dropzone\Form\DropzoneType;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr'=>[
                    'placeholder'=> 'Ici le titre de l\'article',
                ],
                'label'=>'Titre de l\'article *',
                'required'=>true,
            ])
            ->add('content', CKEditorType::class, array(
                'config' => array(
                    'editorplaceholder' => 'Ici le text de votre article',
                ),
                'label'=> 'Texte de l\'article *',
                'required'=>true,
            ))
            ->add('pictureTopLink', DropzoneType::class, [
                'attr'=>[
                    'placeholder' => 'Sélectionner ou glisser l\'image top de l\'article ici',
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
                'label'=>'Image top de l\'article *',
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('isCommented', CheckboxType::class, [
                'label'=>'J\'accept que l\'article soit commenté',
                'required'=>false,
            ])
            ->add('publicationDate', DateType::class, [
                'widget' => 'single_text',
                'required'=>false,
            ])
            ->add('categories', EntityType::class, [
                'attr' => [
                    'class' => 'd-flex justify-content-evenly',
                ],
                'class'=>Categories::class,
                'choice_label'=>'title',
                'expanded' =>true,
                'label'=>'Catégorie de l\'article *',
                'multiple' => true,
                'required' => true,
            ])
            ->add('pictureSecondaryLink', DropzoneType::class, [
                'attr'=>[
                    'placeholder' => 'Sélectionner ou glisser l\'(ou les) image(s) secondaire(s) de l\'article ici',
                ],
                // 'constraints' => [
                //     new File([
                //         'maxSize' => '1024k',
                //         'mimeTypes' => [
                //             'image/*',
                //         ],
                //         'mimeTypesMessage' => 'Veuillez entrer un format de document valide',
                //     ])
                // ],
                'label'=>'Image(s) secondaire de l\'article',
                'mapped'=> false,
                'multiple'=>true,
                'required'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
