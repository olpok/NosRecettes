<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ["label" => 'Titre'])
            ->add('subtitle', null, ["label" => 'Sous-titre (facultatif)'])
           // ->add('ingredients')
            ->add('ingredients', EntityType::class, [
                'label' => 'Ingredient',
                'class' => Ingredient::class,
                'choice_label' => 'name',
                'multiple'=> true
       ] ) 

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
