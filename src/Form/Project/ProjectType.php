<?php

namespace App\Form\Project;

use App\Entity\Project\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('titleJap')
            ->add('token')
            ->add('startYear')
            ->add('endYear')
            ->add('episodeNumber')
            ->add('officialSiteUrl')
            ->add('animeNewsNetworkId')
            ->add('aniDbId')
            ->add('myAnimeListId')
            ->add('releaseResolution')
            ->add('projectVideoQuality')
            ->add('projectStatus')
            ->add('projectType')
            ->add('fansubTeam')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
