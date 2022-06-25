<?php

namespace App\Form\News;

use App\Entity\News\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, ['label' => new TranslatableMessage('column.title', [], 'admin')])
            ->add('content', null, ['label' => new TranslatableMessage('column.content', [], 'admin')])
            ->add('project', null, ['label' => new TranslatableMessage('column.related_project', [], 'admin')])
            ->add('author', null, ['label' => new TranslatableMessage('column.author', [], 'admin')])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
