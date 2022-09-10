<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Products list widget
 */
class ProductsListController extends AbstractController
{
    /**
     * Index
     *
     * @param array $products
     * @param int $page
     * @param bool $isUserExperience
     * @param PaginatorInterface $paginator
     *
     * @return Response
     */
    public function index(array $products, int $page, bool $isUserExperience, PaginatorInterface $paginator): Response
    {
        $products = $paginator->paginate(
            $products,
            $page
        );

        return $this->render('products_list/index.html.twig',
            [
                'products' => $products,
                'isUserExperience' => $isUserExperience
            ]
        );
    }
}