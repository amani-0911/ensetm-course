<?php

namespace App\Form;

use App\Entity\ArticleSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFilereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('moduleSearched', TextType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'chercher module'
                ]
            ])
            ->add('semestreSearched', TextType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'chercher semestre'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleSearch::class,
        ]);
    }
}
