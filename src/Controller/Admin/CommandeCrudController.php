<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

//    public function configureActions(Actions $actions):Actions {
//      return $actions
//                   ->add('index' , 'detail') ;
//    }

public function configureActions(Actions $actions): Actions
{
    return $actions
              ->add('index' , 'detail') ;
}

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
           DateField::new('createdAt'),
           TextField::new('user.nom'),
           MoneyField::new('total')->setCurrency('EUR'),
           BooleanField::new('isPaid','Payé')

        ];
    }

}
