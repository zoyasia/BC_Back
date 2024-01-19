<?php

namespace App\Controller\Admin\Trait;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
trait AdminOnlyTrait
{
    public function configureActions(Actions $actions): Actions
    {
        $actions
        ->setPermission(Action::NEW, 'ROLE_ADMIN')
        ->setPermission(Action::DELETE, 'ROLE_ADMIN')
        ->setPermission(Action::EDIT, 'ROLE_ADMIN')
        ;
        // ->disable(Action::NEW, Action::EDIT, Action::DELETE)
        // ->add(Crud::PAGE_INDEX, Action::DETAIL);

        return $actions;
    }
}