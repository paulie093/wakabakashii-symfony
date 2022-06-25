<?php

namespace App\Form\Project;

use App\Entity\Project\Episode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

class EpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, ['label' => new TranslatableMessage('column.title', [], 'admin')])
            ->add('titleJapRomaji', null, ['label' => new TranslatableMessage('column.title.jap.romaji', [], 'admin')])
            ->add('titleJapKanji', null, ['label' => new TranslatableMessage('column.title.jap.kanji', [], 'admin')])
            ->add('episodeNumber', null, ['label' => new TranslatableMessage('column.episode_number', [], 'admin')])
            ->add('uploadDate', DateType::class, [
                'label' => new TranslatableMessage('column.upload_date', [], 'admin'),
                'widget' => 'single_text',
            ])
            ->add('downloadUrl', null, ['label' => new TranslatableMessage('column.url.download', [], 'admin')])
            ->add('onlineEmbedId', null, ['label' => new TranslatableMessage('column.online_embed_id', [], 'admin')])
            ->add('onlineHost', null, ['label' => new TranslatableMessage('column.online_embed', [], 'admin')])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }
}
