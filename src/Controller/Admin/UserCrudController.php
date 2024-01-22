<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Trait\SuperAdminOnlyTrait;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    // use SuperAdminOnlyTrait;

    public function __construct(
        public UserPasswordHasherInterface $userPasswordHasher
    ) {}
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            ArrayField::new('roles'),
            // ->hideOnForm(),
            // CollectionField::new('roles')
            // ->onlyOnForms(),

            // ChoiceField::new('roles')
            // ->setChoices([
            //     'Client' => 'ROLE_USER',
            //     'Equipe' => 'ROLE_ADMIN',
            //     'Admin'=> 'ROLE_SUPER_ADMIN',
            // ])
            // ->onlyOnForms(),
            EmailField::new('email'),
            TextField::new('password', 'Mot de passe')
            ->onlyWhenCreating(),
            TextField::new('lastname', 'Nom'),            
            TextField::new('firstname', 'Prénom'),
            TextField::new('gender', 'Civilité')
            ->hideOnIndex(),
            TextField::new('address', 'Adresse')
            ->hideOnIndex(),
            TextField::new('zipcode', 'Code Postal')
            ->hideOnIndex(),
            TextField::new('city', 'Ville')
            ->hideOnIndex(),
            // DateField::new('birthdate', 'Date de naissance'),
            TelephoneField::new('phone', 'Téléphone'),


        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setPageTitle('index', '%entity_label_plural%')
        ->setEntityLabelInSingular('Utilisateur')
        ->setEntityLabelInPlural('Utilisateurs');
        // ->setEntityPermission('ROLE_SUPER_ADMIN')
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::INDEX)
        ;
    }
    
}
