<?php

namespace App\Form;

use App\Entity\Avis;
use App\Entity\DomaineFormation;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomaineFormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('slug')
            ->add('description')
            ->add('formations', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('avis', EntityType::class, [
                'class' => Avis::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DomaineFormation::class,
        ]);
    }
}
