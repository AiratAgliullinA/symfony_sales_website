<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\RequestManager;

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
     * @param Request $request
     * @param RequestManager $requestManager
     * @param int $page
     *
     * @return Response
     */
    public function index(ProductRepository $productRepository, Request $request, RequestManager $requestManager, int $page = 1): Response
    {
        if (!$requestManager->isAllGetParametersValid($request)) {
            return $this->redirectToRoute(
                'app_home',
                array_merge(
                    ['page' => $page],
                    $requestManager->getAllValidGetParameters($request)
                )
            );
        }

        return $this->render('home/index.html.twig',
            [
                'products' => $this->getProducts($productRepository, $request),
                'page' => $page,
                'isUserExperience' => false
            ]
        );
    }

    /**
     * Return products list
     *
     * @param ProductRepository $productRepository
     * @param Request $request
     *
     * @return array
     */
    protected function getProducts(ProductRepository $productRepository, Request $request): array
    {
        if ($substring = $request->query->get('substring')) {
            return $productRepository->findBySubstring($substring);
        }

        return $productRepository->findAll();
    }
}