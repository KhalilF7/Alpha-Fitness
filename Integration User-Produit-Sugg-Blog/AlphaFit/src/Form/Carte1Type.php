<?php

namespace App\Form;

use App\Entity\Carte;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class Carte1Type extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeofcard', ChoiceType::class, [
                'choices'  => [
                    'Silver' => 'Silver',
                    'Gold' => 'Gold',
                ],])
            ->add('dateincription', DateType::class, [
                'widget' => 'choice',
                'years' => range(2020,2030)
            ])
            ->add('dateexpiration', DateType::class, [
                'widget' => 'choice',
                'years' => range(2020,2030)
            ])
            ->add('imagecard',FileType::class, [
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],])
            ->add('username',EntityType::class,[
                'class'=>User::class,
                'choice_label'=>'username',
                'empty_data' => '',

            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Carte::class,
        ]);
    }
}
