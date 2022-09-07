<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Header;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\Category;
use App\Controller\Admin\UserCrudController;
use App\Controller\Admin\OrderCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    // public function __construct( 
    //     private AdminUrlGenerator $adminUrlGenerator){

    //     }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        
  
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

         // Option 1. Make your dashboard redirect to the same page for all users
         $url = $adminUrlGenerator->setController(OrderCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('La Boutique');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
         yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
         yield MenuItem::linkToCrud('Orders', 'fas fa-shopping-cart', Order::class);
         yield MenuItem::linkToCrud('Category', 'fas fa-list', Category::class);
         yield MenuItem::linkToCrud('Product', 'fas fa-tags', Product::class);
         yield MenuItem::linkToCrud('Headers', 'fas fa-desktop', Header::class,);
         yield MenuItem::linkToCrud('Carrier', 'fas fa-truck', Carrier::class);
         
    }
}
