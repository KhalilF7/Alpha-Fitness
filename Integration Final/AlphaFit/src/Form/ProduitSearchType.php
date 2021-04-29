<?php

namespace App\Form;

use App\Entity\ProduitSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null,['label' => false,
                'attr' => ['requied' => false,
                    'placeholder' => 'Entrer le nom d\'un produits'] ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProduitSearch::class,
        ]);
    }
}
