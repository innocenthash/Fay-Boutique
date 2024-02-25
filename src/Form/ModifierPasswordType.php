<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType ;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifierPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,['disabled'=>true])
            ->add('prenom',TextType::class,['disabled'=>true])
            ->add('email',EmailType::class ,['disabled'=>true])
            // ->add('roles')
           
          
            ->add('old_password',PasswordType::class,[
                'label'=>'Mon mot de passe actuel ' ,
                'mapped'=>false ,
                'required'=>true ,
                'attr' =>
                 [
                       'placeholder'=>"Veuillez saisir votre mot de passe actuel"
                ]
            ])
            ->add('new_password',RepeatedType::class,[
                'type'=> PasswordType::class ,
              
                'required'=>true ,
                'mapped'=>false ,
                'invalid_message'=> 'Le mot de passe et la confirmation doivent etre identique' ,

                'first_options'=> [
                    'label'=> 'Mot nouveau mot de passe' ,
                    'attr' =>
                 [
                       'placeholder'=>"Veuillez saisir votre nouveau mot de passe "
                ]

                ] ,

                'second_options'=> [
                    'label'=> 'Confirmez votre nouveau mot de passe' ,
                    'attr' =>
                    [
                          'placeholder'=>"Veuillez confirmer votre nouveau mot de passe "
                   ]
                ]

                
            ])

            ->add('submit',SubmitType::class,['label'=>"Mis à jour"  , 
             'attr'=> [
                'class'=> 'btn btn-primary w-100 text-white'
             ]
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
