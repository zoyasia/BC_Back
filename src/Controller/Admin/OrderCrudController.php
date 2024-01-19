<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            AssociationField::new('employee', 'Employé.e'),
            TextField::new('status', 'Statut'),
            DateField::new('drop_date', 'Dépôt'),
            DateField::new('pickup_date', 'Récupération'),
            NumberField::new('total_price', 'Montant total'), // voir en DB si on store le montant en cents pour pb d'arrondis + MoneyField
            DateField::new('payment_date', 'Réglé le:'),
            AssociationField::new('customer', 'Client'),
            // CollectionField::new('selection')
        ];
    }
    
}
