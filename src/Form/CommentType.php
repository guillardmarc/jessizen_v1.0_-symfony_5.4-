<?php

namespace App\Form;

use App\Entity\ArticlesComments;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('createdAt')
            // ->add('modifiedAt')
            ->add('content', CKEditorType::class, [
                'config' => array(
                    'editorplaceholder' => 'Ici le text de votre commentaire',
                ),
                'label'=> 'Ajouter un commentaire',
            ])
            // ->add('articles')
            // ->add('author')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticlesComments::class,
        ]);
    }
}
