<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomplacement',TextType::class,[
                  'label'=>'Emplacement',
                  'attr'=> [
                    'placeholder'=>  'Specifiez vos emplacements'
                  ]
            ])
            ->add('nom', TextType::class, [
                'label'=> 'Nom' ,

                'attr'=> [
                    'placeholder'=> "Votre nom"
                ]
                
                ])
            ->add('prenom' , TextType::class, [
                'label'=> 'Prenom' ,

                'attr'=> [
                    'placeholder'=> "Votre prenom"
                ]
            ])
           
            ->add('adresse', TextType::class, [
                'label'=> 'adresse' ,

                'attr'=> [
                    'placeholder'=> "Votre adresse"
                ]
            ])
            ->add('ville',TextType::class, [
                'label'=> 'ville' ,

                'attr'=> [
                    'placeholder'=> "Votre ville"
                ]
            ])
            ->add('pays',CountryType::class, [
                'label'=> 'Pays' ,

                'attr'=> [
                    'placeholder'=> "Votre pays"
                ]
            ])
            ->add('telephone',TelType::class, [
                'label'=> 'Numero  telephone' ,

                'attr'=> [
                    'placeholder'=> "Votre contact selon l'adresse "
                ]
            ])
            ->add('repere',TextType::class, [
                'label'=> 'Repère' ,

                'attr'=> [
                    'placeholder'=> "Le repère le plus proche que possible"
                ]
            ])

            ->add('submit',SubmitType::class, [
                'label'=> 'Ajouter mon adresse' ,

                'attr'=> [
                     'class'=>"btn btn-block btn-dark w-100"
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
