<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Trait\AdminOnlyTrait;
use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ServiceCrudController extends AbstractCrudController
{
    // use AdminOnlyTrait;
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextEditorField::new('description'),
            NumberField::new('price', 'Prix'),
            AssociationField::new('articles', 'Articles pris en charge')
                ->onlyOnIndex(),
            AssociationField::new('articles')
                ->hideOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Services');
    }

    /**
     * A la suppression du service, ne supprime pas les articles associés à ce service
     */
    public function deleteEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Service)
            return;

        foreach ($entityInstance->getArticles() as $article) {
            $article->removeService($entityInstance);
        }

        parent::deleteEntity($em, $entityInstance);
    }

}
