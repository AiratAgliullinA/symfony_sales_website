<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Dashboard
 *
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * Index
     *
     * @Route("/admin", name="app_admin")
     *
     * @return Response
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(ProductCrudController::class)->generateUrl());
    }

    /**
     * Configure menu items
     *
     * @return iterable
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Content');
        yield MenuItem::linkToCrud('Products', 'fa fa-list', Product::class);
    }
}