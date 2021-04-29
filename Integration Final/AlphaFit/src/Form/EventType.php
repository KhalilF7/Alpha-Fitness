<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descritption')
            ->add('datedebut')
            ->add('nomevenement')
            ->add('nbplace')
            ->add('datefin')
            ->add('idCategorie', EntityType
            ::class, [
                'class' => Categories::class,

                'choice_label' => 'nomCategorie',
            ])        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
