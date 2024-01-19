<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Trait\AdminOnlyTrait;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    // use AdminOnlyTrait;
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextField::new('description'),
            NumberField::new('price', 'Prix'),
            AssociationField::new('category', 'Catégorie'),
            AssociationField::new('services', 'Services disponibles')
            ->onlyOnIndex(),
            AssociationField::new('services')
            ->hideOnIndex(),
            
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Articles');
    }

        /**
     * A la suppression de l'article, ne supprime pas les services associés à cet article
     */
    public function deleteEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Article)
            return;

        foreach ($entityInstance->getServices() as $service) {
            $service->removeArticle($entityInstance);
        }

        parent::deleteEntity($em, $entityInstance);
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }
    
}
