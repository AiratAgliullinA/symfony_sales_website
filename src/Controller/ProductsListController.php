<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Products list widget
 */
class ProductsListController extends AbstractController
{
    /**
     * Index
     *
     * @param array $products
     * @param bool $isUserExperience
     *
     * @return Response
     */
    public function index(array $products, bool $isUserExperience = false): Response
    {
        return $this->render('products_list/index.html.twig',
            [
                'products' => $products,
                'isUserExperience' => $isUserExperience
            ]
        );
    }
}