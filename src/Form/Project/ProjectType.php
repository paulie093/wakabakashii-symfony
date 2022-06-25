<?php

namespace App\Form\Project;

use App\Entity\Project\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, ['label' => new TranslatableMessage('column.title', [], 'admin')])
            ->add('titleJap', null, ['label' => new TranslatableMessage('column.title.jap', [], 'admin')])
            ->add('token', null, ['label' => new TranslatableMessage('column.token', [], 'admin')])
            ->add('startYear', null, ['label' => new TranslatableMessage('column.year.start', [], 'admin')])
            ->add('endYear', null, ['label' => new TranslatableMessage('column.year.end', [], 'admin')])
            ->add('episodeNumber', null, ['label' => new TranslatableMessage('column.episodes', [], 'admin')])
            ->add('officialSiteUrl', null, ['label' => new TranslatableMessage('column.url.official', [], 'admin')])
            ->add('animeNewsNetworkId', null, ['label' => new TranslatableMessage('column.ann_id', [], 'admin')])
            ->add('aniDbId', null, ['label' => new TranslatableMessage('column.anidb_id', [], 'admin')])
            ->add('myAnimeListId', null, ['label' => new TranslatableMessage('column.mal_id', [], 'admin')])
            ->add('releaseResolution', null, ['label' => new TranslatableMessage('column.resolution', [], 'admin')])
            ->add('projectVideoQuality', null, ['label' => new TranslatableMessage('column.project.video_quality', [], 'admin')])
            ->add('projectStatus', null, ['label' => new TranslatableMessage('column.project.status', [], 'admin')])
            ->add('projectType', null, ['label' => new TranslatableMessage('column.project.type', [], 'admin')])
            ->add('fansubTeam', null, ['label' => new TranslatableMessage('column.fansub.team', [], 'admin')])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
