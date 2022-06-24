<?php

namespace App\Form\Project;

use App\Entity\Project\Episode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('titleJapRomaji')
            ->add('titleJapKanji')
            ->add('episodeNumber')
            ->add('uploadDate')
            ->add('downloadUrl')
            ->add('onlineEmbedId')
            ->add('project')
            ->add('onlineHost')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }
}
