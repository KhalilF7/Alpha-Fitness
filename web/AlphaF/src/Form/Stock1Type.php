<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Produit1;
use App\Entity\Stock1;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Stock1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateentree')
            ->add('quantite')
            ->add('idproduit', EntityType::class, [
        'class' => Produit1::class,
        'choice_label' => 'nom'
    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock1::class,
        ]);
    }
}
