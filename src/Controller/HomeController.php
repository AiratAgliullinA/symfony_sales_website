<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Home controller
 */
class HomeController extends AbstractController
{
    /**
     * Index
     *
     * @Route("/{page<\d+>}", name="app_home")
     * @param ProductRepository $productRepository
     * @param int $page
     *
     * @return Response
     */
    public function index(ProductRepository $productRepository, int $page = 1): Response
    {
        return $this->render('home/index.html.twig',
            [
                'products' => $this->getProducts($productRepository),
                'page' => $page,
                'isUserExperience' => false
            ]
        );
    }

    /**
     * Return products list
     *
     * @param ProductRepository $productRepository
     *
     * @return array
     */
    protected function getProducts(ProductRepository $productRepository): array
    {
        return $productRepository->findAll();
    }
}