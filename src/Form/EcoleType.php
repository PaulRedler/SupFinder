<?php

namespace App\Form;

use App\Entity\Ecole;
use App\Entity\Group;
use App\Entity\Media;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EcoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('slug')
            ->add('emailContact')
            ->add('siteWeb')
            ->add('descriptionCourte')
            ->add('descriptionLongue')
            ->add('logoUrl')
            ->add('titre')
            ->add('createdAt')
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('groups', EntityType::class, [
                'class' => Group::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('media', EntityType::class, [
                'class' => Media::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ecole::class,
        ]);
    }
}
