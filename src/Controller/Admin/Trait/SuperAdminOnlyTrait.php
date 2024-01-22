<?php

namespace App\Controller\Admin\Trait;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
trait SuperAdminOnlyTrait
{
    public function configureActions(Actions $actions): Actions
    {
        $actions
        ->setPermission(Action::NEW, 'ROLE_SUPER_ADMIN')
        ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN')
        ->setPermission(Action::EDIT, 'ROLE_SUPER_ADMIN')
        ;
        // ->disable(Action::NEW, Action::EDIT, Action::DELETE)
        // ->add(Crud::PAGE_INDEX, Action::DETAIL);

        return $actions;
    }
}