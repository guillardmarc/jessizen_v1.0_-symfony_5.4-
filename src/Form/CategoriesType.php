<?php

namespace App\Form;

use App\Entity\Categories;
use Doctrine\DBAL\Types\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\UX\Dropzone\Form\DropzoneType;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TypeTextType::class, [
                'attr'=>[
                    'placeholder'=>'Ici le titre de la catégorie'
                ],
                'label'=>"Titre de la catégorie *",
                'required'=>True,
            ])
            ->add('moreInfo', CKEditorType::class, [
                'config'=>array(
                    'editorplaceholder'=>'Ici la description de la catégorie'
                ),
                'label'=>'Description de la catégorie',
                'required'=>false,
            ])
            ->add('picture', DropzoneType::class, [
                'attr'=>[
                    'placeholder' => 'Sélectionner ou glisser l\'image de la catégorie ici',
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
                'label'=>'Image de la catégorie',
                'mapped'=>false,
                'required'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}
