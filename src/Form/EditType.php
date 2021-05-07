<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditType extends AbstractType
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
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
            ]);
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
