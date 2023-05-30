<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            // Email + Confirmation
            ->add('email', RepeatedType::class, [
                // FormType du champ à répéter
                'type' => EmailType::class,

                // Definir le premier champ comme Obligatoire
                'required' => true,

                // Label global
                // 'label' => "Your Email",

                // Options appliquées sur les deux champ
                // 'options' => ['attr' => ['class' => 'password-field']],
                
                // Options du premier champ
                'first_options'  => [
                    'label' => 'Your Email'
                ],
                
                // Option du champ de répétition
                'second_options' => [
                    'label' => 'Email confirmation'
                ],
                
                // Contraintes
                // 'invalid_message' => 'The password fields must match.',
            ])

            // Password + Confirmation
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,

                'first_options'  => [
                    'label' => 'Your new password'
                ],
                'second_options' => [
                    'label' => 'Your new password confirmation'
                ],

                // Contraintes
                //     'constraints' => [
                //         new NotBlank([
                //             'message' => 'Please enter a password',
                //         ]),
                //         new Length([
                //             'min' => 6,
                //             'minMessage' => 'Your password should be at least {{ limit }} characters',
                //             // max length allowed by Symfony for security reasons
                //             'max' => 4096,
                //         ]),
                //     ],
            ])

            // Firstname

            // Lastname

            // Birshday

            // Gender

            // Country


            ->add('agreeTerms', CheckboxType::class, [
                'label' => "I agree with <a href=\"#\">terms</a>",
                'label_html' => true,

                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
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
