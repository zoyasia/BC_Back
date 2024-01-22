<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Service;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');


        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(OrderCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Frimousse Pressing');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Ventes');
        yield MenuItem::linkToCrud('Commandes', 'fas fa-clipboard-list', Order::class);

        yield MenuItem::section('Pressing');
        yield MenuItem::linkToCrud('Articles', 'fas fa-shirt', Article::class);
        yield MenuItem::linkToCrud('Services', 'fas fa-jug-detergent', Service::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Category::class);

        yield MenuItem::section('Clients');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
    }

//     public function configureActions(Actions $actions): Actions
// {
//         return $actions
//         // you can set permissions for built-in actions in the same way
//         ->setPermission(Action::NEW, 'ROLE_SUPER_ADMIN')
//         ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN')
//     ;
// }



}
