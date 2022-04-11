<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('passwd')
            ->add('createdat')
            ->add('imgurl')
            ->add('firstname')
            ->add('lastname')
            ->add('domaine')
            ->add('departement')
            ->add('typeclub')
            ->add('class')
            ->add('localisation')
            ->add('entreprisename')
            ->add('role')
            ->add('state')
            ->add('cinfollower')
            ->add('idoffer')
            ->add('likepost')
            ->add('idevent')
            ->add('idforum')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
