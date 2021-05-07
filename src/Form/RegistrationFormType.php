<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom',TextType::class,['attr' => ['class' => 'form-control']])
            ->add('Matricule',TextType::class,['attr' => ['class' => 'form-control']])
            ->add('Contact',TextType::class,['attr' => ['class' => 'form-control']])
            ->add('IP',TextType::class,['attr' => ['class' => 'form-control']])
            ->add('email',EmailType::class,['attr' => ['class' => 'form-control']])
            ->add('roles', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'status',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
            ])
            ->add('Password', RepeatedType::class, [

                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'form-control',]],
                //  'required' => true,
                'first_options'  => ['label' => 'Mot de passe:'],
                'second_options' => ['label' => 'Confirmer mot de passe:'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit au moins avoir {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray){
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString){
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
