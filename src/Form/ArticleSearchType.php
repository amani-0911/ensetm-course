<?php

namespace App\Form;

use App\Entity\ArticleSearch;
use App\Entity\Filieres;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleSearchType extends AbstractType
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
            ->add('filieresSearched', EntityType::class,[
                'required' => false,
                'label' => false,
                'class' => Filieres::class,
                'choice_label' => 'nom',
                'attr' =>[
                    'class' =>'select-fil'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleSearch::class,
            'method'=> 'get',
            'csrf_protection' =>false
        ]);
    }
    public function getBlockPrefix()
    {
        return'';
    }
}
