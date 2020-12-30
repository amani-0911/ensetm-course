<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Filieres;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('contenu', CKEditorType::class)
            ->add('module', TextType::class)
            ->add('semestre', TextType::class)
            ->add('Filiers', EntityType::class,[
                'required' => true,
                'class' => Filieres::class,
                'label' => false,
                'choice_label' => 'nom',
                'multiple' => true,
                'attr' =>[
                    'class' =>'select-fil'
                ]
            ])
            ->add('files', FileType::class,[
                  'label' => false,
                'required' => false,
                  'multiple' => true,
                    'mapped' =>false
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }

}
