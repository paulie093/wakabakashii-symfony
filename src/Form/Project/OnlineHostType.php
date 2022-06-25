<?php

namespace App\Form\Project;

use App\Entity\Project\OnlineHost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

class OnlineHostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, ['label' => new TranslatableMessage('column.name.name', [], 'admin')])
            ->add('url', null, ['label' => new TranslatableMessage('column.url.embed', [], 'admin')])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OnlineHost::class,
        ]);
    }
}
