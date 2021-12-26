<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Header;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\CarrierRepository;
use App\Controller\Admin\OrderCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    /*
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(OrderCrudController::class)->generateUrl());
    }
    */

    public function admin(
        UserRepository $userRepository,
        OrderRepository $orderRepository,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        CarrierRepository $carrieRepository,
    ): Response {
        $users      = $userRepository->findAll();
        $orders     = $orderRepository->findAll();
        $categories = $categoryRepository->findAll();
        $products   = $productRepository->findAll();
        $carries    = $carrieRepository->findAll();

        $userCount = 0;
        foreach ($users as $user) {
            $userCount += 1;
        }
        $orderCount = 0;
        foreach ($orders as $order) {
            $orderCount += 1;
        }
        $categoryCount = 0;
        foreach ($categories as $category) {
            $categoryCount += 1;
        }
        $productCount = 0;
        foreach ($products as $product) {
            $productCount += 1;
        }
        $carrieCount = 0;
        foreach ($carries as $carrie) {
            $carrieCount += 1;
        }
        
        return $this->render('admin/dashboard.html.twig', [
            'users'         => $userCount,
            'orders'        => $orderCount,
            'categories'    => $categoryCount,
            'products'     => $productCount,
            'carries'      => $carrieCount,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ART DECO');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Products', 'fas fa-tag', Product::class);
        yield MenuItem::linkToCrud('Carries', 'fas fa-truck', Carrier::class);
        //yield MenuItem::linkToCrud('Headers', 'fas fa-desktop', Header::class);
    }

}
