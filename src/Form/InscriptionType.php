<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom'
        
        ,TextType::class,[
    // 'label'=> 'votre nom',
    'constraints'=> new Length(
        [
        'min'=>2,
        'max'=>50
    ]
    ) ,
    'attr'=> [
        'placeholder'=>'Merci de saisir votre nom' ,
        'class'=>' '
    ]
    ]
    )
        ->add('prenom'
        ,TextType::class,[
    // 'label'=> 'votre nom',
    'constraints'=> new Length(  [
        'min'=>2,
        'max'=>30
    ]) ,
    'attr'=> [
        'placeholder'=>'Merci de saisir votre prenom'
    ]
    ])
            ->add('email'
            ,EmailType::class,[
    // 'label'=> 'votre nom',
    'attr'=> [
        'placeholder'=>'votre adresse email'
    ]
    ])
            // ->add('roles')
            ->add('password',
            RepeatedType::class,[
            
            'type'=>PasswordType::class,
            'invalid_message'=> 'Le mot de passe et la confirmation doivent etre identique' ,
     
     'required'=>true,
     "first_options"=>['label'=>'Mot de passe'] ,
      "second_options"=>['label'=>'Confirmez votre mot de passe'] ,
   
            
            ]
            
    )

    ->add('submit',SubmitType::class,['label'=>"S'inscrire",'attr'=>[
        'class'=> 'btn  btn-block btn-lg w-100 btn-inscription  '
    ]])
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
