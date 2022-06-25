<?php

namespace App\Form\Project;

use App\Entity\Project\ProjectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

class ProjectTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('token', null, ['label' => new TranslatableMessage('column.token', [], 'admin')])
            ->add('name', null, ['label' => new TranslatableMessage('column.name.name', [], 'admin')])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectType::class,
        ]);
    }
}
