<?php

namespace App\Form;

use App\Entity\Courrier;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_c',TextType::class,[
                'label' => 'Nom du courrier',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('notes', TextareaType::class,[
                "attr" => [
                    "class" => "form-control"
                ]
            ])

            ->add('status',ChoiceType::class,[
                "choices" =>[
                    'Très urgent' => 'TRES URGENT',
                    'Urgent' => 'URGENT',
                    'Pas urgent' => 'PAS URGENT',
                ],
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('fichier',FileType::class,[
                'label' => 'choississez votre fichier',
                "attr" => [
                    "class" => "form-control",
                    "accept" => ".csv, .xlsx, .xls",

                ],
               'constraints' => [
                  new File([
                      'mimeTypes' => [
                            "application/vnd.ms-excel",
                            "application/msexcel",
                            "application/x-msexcel",
                            "application/x-ms-excel",
                            "application/x-excel",
                            "application/x-dos_ms_excel",
                            "application/xls",
                            "application/x-xls",
                            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                            "text/x-csv",
                            "application/csv",
                            "application/x-csv",
                            "text/csv",
                            "text/plain",
                            "text/comma-separated-values",
                            "text/x-comma-separated-values",
                            "text/tab-separated-values",  
                            

                      ],

                      'mimeTypesMessage' => 'Uploader un document PDF valid',
                  ])
            ]
                ])


            ->add('recipient',EntityType::class,[
                "class" => User::class,
                'label' => 'Destinataire',
                "choice_label" => "Nom",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add ('envoyer', SubmitType::class,[
                "attr" => [
                    "class" => "btn btn-outline-warning waves-effect\""

                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Courrier::class,
        ]);
    }
}
