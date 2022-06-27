<?php

namespace App\Form\News;

use App\Entity\News\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Validator\Constraints\File;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, ['label' => new TranslatableMessage('column.title', [], 'admin')])
            ->add('content', null, ['label' => new TranslatableMessage('column.content', [], 'admin')])
            ->add('project', null, ['label' => new TranslatableMessage('column.related_project', [], 'admin')])
            ->add('author', null, ['label' => new TranslatableMessage('column.author', [], 'admin')])
            ->add('image1', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => new TranslatableMessage('column.image.news', ['%number%' => 1], 'admin'),
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['image/png'],
                    ])
                ]
            ])
            ->add('image2', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => new TranslatableMessage('column.image.news', ['%number%' => 2], 'admin'),
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['image/png'],
                    ])
                ]
            ])
            ->add('image3', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => new TranslatableMessage('column.image.news', ['%number%' => 3], 'admin'),
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['image/png'],
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
