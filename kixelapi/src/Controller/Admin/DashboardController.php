<?php

namespace App\Controller\Admin;

use App\Controller\UserController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Bloc;
use App\Entity\Commentaire;
use App\Entity\DataSet;
use App\Entity\Page;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(UserController::class)->generateUrl());
        
        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
            //     return $this->redirect('...');
            // }
            
            // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
            // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
            //
            // return $this->render('some/path/my-dashboard.html.twig');
            return $this->render('/MenuCrud.html.twig');
            
            
            return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Kixelapi');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Articles', 'fas fa-list', Article::class);
        yield MenuItem::linkToCrud('Blocs', 'fas fa-list', Bloc::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-list', Commentaire::class);
        yield MenuItem::linkToCrud('Data Sets', 'fas fa-list', DataSet::class);
        yield MenuItem::linkToCrud('Page', 'fas fa-list', Page::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
