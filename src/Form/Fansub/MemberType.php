<?php

namespace App\Form\Fansub;

use App\Entity\Fansub\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname', null, ['label' => new TranslatableMessage('column.name.nick', [], 'admin')])
            ->add('fansubTeam', null, ['label' => new TranslatableMessage('column.fansub.team', [], 'admin')])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
