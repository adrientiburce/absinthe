<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'email@centrale.centralelille.fr']
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo (optionnel)',
                'attr' => ['placeholder' => 'votre pseudo'],
                'required' => false,
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe (min 6 caractères)',
            ])
            ->add('confirm_password', PasswordType::class,[
                'label' => 'Confirmation du mot de passe',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
