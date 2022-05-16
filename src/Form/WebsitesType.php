<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Websites;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\UX\Dropzone\Form\DropzoneType;

class WebsitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('logoText', TextType::class, [
                'attr'=>[
                    'placeholder'=>'Ici le nom du site',
                ],
                'label'=>'Texte logo*',
                'required'=>true
            ])
            ->add('logoPicture', DropzoneType::class, [
                'attr'=>[
                    'placeholder' => 'Sélectionner ou glisser le logo du site ici',
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
                'label'=>'Image logo',
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('copyright', CKEditorType::class, [
                'config'=>array(
                    'editorplaceholder'=>'Ici la description du copyright'
                ),
                'label'=>'Copyright*',
                'required'=>true,
            ])
            ->add('regulation', CKEditorType::class, [
                'config'=>array(
                    'editorplaceholder'=>'Ici le reglement du site'
                ),
                'label'=>'Règlement du site*',
                'required'=>true,
            ])
            ->add('version*', NumberType::class, [
                'attr'=>[
                    'placeholder'=>'Indiquer le numéro de la version du site ici'
                ],
                'label'=> 'Numéro de version',
                'required'=>true,
            ])
            ->add('presentationText', CKEditorType::class, [
                'config'=>array(
                    'editorplaceholder'=>'Ici la présentation du site'
                ),
                'label'=>'Présentation du site*',
                'required'=>true,
            ])
            ->add('presentationPicture', DropzoneType::class,  [
                'attr'=>[
                    'placeholder' => 'Sélectionner ou glisser l\'image de présentation ici',
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
                'label'=>'Image de présentation',
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('publicationDate', DateType::class, [
                'label'=>'Date de publication',
                'widget'=>'single_text',
                'required'=>false,
            ])
            ->add('developper', EntityType::class, [
                'class' => Users::class,
                'choice_label'=>'email',
                'label' => 'Développeur du site*',
                'placeholder'=>'Selectionner l\'email du développeur',
                'required' => true,
            ])
            ->add('owner', EntityType::class, [
                'class' => Users::class,
                'choice_label'=>'email',
                'label' => 'Propriétaire du site*',
                'placeholder'=>'Selectionner l\'email du propriétaire',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Websites::class,
        ]);
    }
}
