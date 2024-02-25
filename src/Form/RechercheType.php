<?php
namespace App\Form ;

use App\ClassRecherche\Recherche;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class  RechercheType extends AbstractType {


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('nom' , TextType::class , [
          'label'=>false ,
            'required'=> false ,
            'attr'=>
             [
                'class'=> ''
            ]
        ]) 

        ->add('categories' , EntityType::class , [
            'class'=>Category::class ,
            'label'=>false ,
              'multiple'=> true,
               "expanded"=>true ,
               'required'=> false ,

              'attr'=>
               [
                  'class'=> ''
              ]
          ]) 

          ->add('submit',SubmitType::class,['label'=>"Rechercher",'attr'=>[
            'class'=> 'btn btn-success btn-block btn-lg w-100 btn-recherche  '
        ]]) ;

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recherche::class,
            'method'=> 'GET' ,
            'crsf_protection'=>false
        ]);
    }

    public function getBlockPrefix() {
            return '' ;
    }
}