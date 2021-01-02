<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'label' => 'Pseudo',
                'attr'   =>  array(
                'class'   => 'text-center mb-5')
            ])
            ->add('lastname', null, [
                'label' => 'Nom',
                'attr'   =>  array(
                'class'   => 'text-center mb-5')
            ])
            ->add('firstname', null, [
                'label' => 'Prénom',
                'attr'   =>  array(
                'class'   => 'text-center mb-5')
            ])
            ->add('mail', null, [
                'label' => 'Email',
                'attr'   =>  array(
                'class'   => 'text-center mb-5')
            ])
            ->add('phone', null, [
                'label' => 'Numéro de téléphone',
                'attr'   =>  array(
                'class'   => 'text-center mb-5')
            ])
            ->add('address', null, [
                    'label' => 'Adresse',
                    'attr'   =>  array(
                    'class'   => 'text-center mb-5')
            ])
            ->add('Modifier', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
