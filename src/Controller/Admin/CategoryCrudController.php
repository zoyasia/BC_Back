<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Trait\AdminOnlyTrait;
use App\Controller\Admin\Trait\ReadOnlyTrait;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    // use AdminOnlyTrait;
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('name', 'Nom'),
            AssociationField::new('articles')
            ->onlyOnIndex(),
            ArrayField::new('articles')
            ->onlyOnDetail(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Catégories');
    }

    /**
     * A la suppression de la catégorie, supprime tous les articles qui y sont reliés
     */
    public function deleteEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Category) return;

        foreach ($entityInstance->getArticles() as $artice) {
            $em->remove($artice);
        }

        parent::deleteEntity($em, $entityInstance);
    }
    
}
