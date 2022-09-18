<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Products list widget
 */
class ProductsListController extends AbstractController
{
    /**
     * Index
     *
     * @param PaginationInterface $products
     * @param bool $isUserExperience
     *
     * @return Response
     */
    public function index(PaginationInterface $products, bool $isUserExperience): Response
    {
        return $this->render('products_list/index.html.twig',
            [
                'products' => $products,
                'isUserExperience' => $isUserExperience
            ]
        );
    }
}