<?php

namespace App\Form;

use App\Entity\DetailsCommande;
use App\Entity\Produit;
use App\Entity\Stock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailsCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numc')
            ->add('qteproduit')
            ->add('prixproduit')
            ->add('idproduit', EntityType::class, [
                'class' => Stock::class,
                'choice_label' => 'id'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetailsCommande::class,
        ]);
    }
}
