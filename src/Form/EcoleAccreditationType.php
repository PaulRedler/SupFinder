<?php

namespace App\Form;

use App\Entity\Accreditation;
use App\Entity\Ecole;
use App\Entity\EcoleAccreditation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EcoleAccreditationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateObtention')
            ->add('dateExpi')
            ->add('accreditation', EntityType::class, [
                'class' => Accreditation::class,
                'choice_label' => 'id',
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
            'data_class' => EcoleAccreditation::class,
        ]);
    }
}
