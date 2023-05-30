<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $year = date('Y');
        $min_year = $year - 100;

        $gender_choices = $options['genders'];

        // Récupération de l'option "country"
        $country = $options['country'];

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
                    'label' => 'Your Email',
                    'label_attr' => [
                        'hidden' => "hidden"
                    ],
                    'attr' => [
                        'placeholder' => 'Your Email'
                    ]
                ],
                
                // Option du champ de répétition
                'second_options' => [
                    'label' => 'Email confirmation',
                    'label_attr' => [
                        'hidden' => "hidden"
                    ],
                    'attr' => [
                        'placeholder' => 'Email confirmation'
                    ]
                ],
                
                // Contraintes
                // 'invalid_message' => 'The password fields must match.',
            ])

            // Password + Confirmation
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,

                'first_options'  => [
                    'label' => 'Your new password',
                    'label_attr' => [
                        'hidden' => "hidden"
                    ],
                    'attr' => [
                        'placeholder' => 'Your new password'
                    ]
                ],
                'second_options' => [
                    'label' => 'Your new password confirmation',
                    'label_attr' => [
                        'hidden' => "hidden"
                    ],
                    'attr' => [
                        'placeholder' => 'Your new password confirmation'
                    ]
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
            ->add('firstname', TextType::class, [
                'label' => "Your firstname",
                'required' => true,
                'attr' => [
                    'placeholder' => "Your firstname"
                ],
                'constraints' => [],
            ])

            // Lastname
            ->add('lastname', TextType::class, [
                'label' => "Your lastname",
                'required' => true,
                'attr' => [
                    'placeholder' => "Your lastname"
                ],
                'constraints' => [],
            ])

            // Birshday
            ->add('birthday', BirthdayType::class, [
                'label' => "Your birthday",
                'required' => true,
                'attr' => [
                    'placeholder' => "Your birthday"
                ],
                'help'=> "Select your birthday",

                // Modifie la liste des jours
                // 'days' => [],

                // Modifie la liste des mois
                // 'months' => [],
                
                // Modifie la liste des années
                'years' => range($year, $min_year),

                'constraints' => [],
            ])

            // Gender
            ->add('gender', ChoiceType::class, [
                'label' => "Select your gender",
                'required' => true,
                // 'attr' => [
                //     'placeholder' => "Select your gender"
                // ],
                'placeholder' => "Select your gender",
                
                // 'choices' => [
                //     'Male' => "M",
                //     'Female' => "F",
                //     'Neither' => "N",
                // ],
                'choices' => array_flip($gender_choices),

                'constraints' => [],
            ])

            // Country
            ->add('country', CountryType::class, [
                'label' => "Select your country",
                'required' => true,
                // 'attr' => [
                //     'placeholder' => "Your country"
                // ],
                'placeholder' => "Select your country",
                'data' => $country,
                'constraints' => [],
            ])
        ;

        if ($options['show_agreeterms'])
        {
            $builder->add('agreeTerms', CheckboxType::class, [
                'label' => "I agree with <a href=\"#\">terms</a>",
                'label_html' => true,
    
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'country' => null, // Definition de l'option "country"
            'genders' => [],
            'show_agreeterms' => true,
        ]);
    }
}
