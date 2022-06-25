<?php

namespace App\Form\Fansub;

use App\Entity\Fansub\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, ['label' => new TranslatableMessage('column.name.name', [], 'admin')])
            ->add('token', null, ['label' => new TranslatableMessage('column.token', [], 'admin')])
            ->add('shortName', null, ['label' => new TranslatableMessage('column.name.short', [], 'admin')])
            ->add('websiteUrl', null, ['label' => new TranslatableMessage('column.url.website', [], 'admin')])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
