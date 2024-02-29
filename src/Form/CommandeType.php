<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Livraison;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user=$options['user'] ;
        $builder
            ->add('adresses',EntityType::class,[
                'label'=> 'Choisissez vos adresses de livraison',
                'required'=> true ,
                'choices'=> $user->getAdresses() ,
                 'class'=> Adresse::class ,
                 'multiple'=> false ,
                 'expanded'=>true
            ])
            ->add('livreurs',EntityType::class,[
                'label'=> 'Choisissez vos livreurs',
                'required'=> true ,
                // 'choices'=> $user->getAdresses() ,
                 'class'=> Livraison::class ,
                 'multiple'=> false ,
                 'expanded'=>true
            ])

            ->add('submit',SubmitType::class,[
                'label'=> 'Valider ma commande',
                'attr'=> [
                    'class'=> 'btn btn-success w-100'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
          'user'=>array()
        ]);
    }
}
