<?php

namespace App\Form;

use App\Entity\DomaineFormation;
use App\Entity\Ecole;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule')
            ->add('diplome')
            ->add('modeFormation')
            ->add('coutMin')
            ->add('coutMax')
            ->add('page')
            ->add('slug')
            ->add('createdAt')
            ->add('domainesFormation', EntityType::class, [
                'class' => DomaineFormation::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('ecole', EntityType::class, [
                'class' => Ecole::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
