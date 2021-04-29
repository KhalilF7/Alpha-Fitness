<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Commande;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numc')
            ->add('idclient',EntityType::class,array('class' => User::class,'choice_label' => 'UserName' ))
            ->add('datecom', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('montantcom')
            ->add('etatcom', ChoiceType::class,[
                'choices' =>[
                    'En cours'=> 'En cours',
                    'Terminé'=> 'Terminé',
                    'Annulé'=> 'Annulé',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
