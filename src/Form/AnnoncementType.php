<?php

namespace App\Form;

use App\Entity\Annoncement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject')
            ->add('content')
            ->add('destination')
            ->add('createdat')
            ->add('catann')
            ->add('state')
            ->add('idsender')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annoncement::class,
        ]);
    }
}
