<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'disabled' => true,
                'label' => 'Mon adresse mail'
            ])
            ->add('firstname', TextType::class,[
                'disabled' => true,
                'label' => 'Mon prenom'
            ])
            ->add('lastname', TextType::class,[
                'disabled' => true,
                'label' => 'Mon nom'
            ])
            ->add('old_password', PasswordType::class,[
                'mapped' => false,
                'label' => 'Mon mot de passe actuel',
                'attr' =>[
                    'placeholder' => 'veuillez saisir votre mot de passe actuel'
                ]
            ])

            ->add('new_password', RepeatedType::class,[
                'type' => PasswordType::class,
                'mapped' => false,
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30  
                  ]),
                'invalid_message'=> 'Le mot de passe ainsi que la confirmation doivent être identique',
                'label' => 'Mon nouveau mot de passe',
                'required' => true,
                'first_options' => ['label' => 'Mon nouveau mot de passe',
                'attr' =>[
                    'placeholder' => 'merci de saisir votre nouveau mot de passe'
                ]
            ],
                'second_options' => ['label' => 'Confirmer votre nouveau mot de passe',
                'attr' =>[
                    'placeholder' => 'merci de confirmer votre nouveau mot de passe'
                ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour"
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
