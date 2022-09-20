<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\RequestManager;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use App\Entity\Product;

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
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @param RequestManager $requestManager
     * @param PaginatorInterface $paginator
     * @param int $page
     *
     * @return Response
     */
    public function index(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        Request $request,
        RequestManager $requestManager,
        PaginatorInterface $paginator,
        int $page = 1
    ): Response
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
        $products = $this->getProducts($productRepository, $request, $paginator, $page);

        return $this->render('home/index.html.twig',
            [
                'products' => $products,
                'categories' => $categoryRepository->findAll(),
                'page' => $page,
                'isUserExperience' => false,
                'sortItems' => $this->getSortItems($request)
            ]
        );
    }

    /**
     * Return products list
     *
     * @param ProductRepository $productRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param int $page
     *
     * @return PaginationInterface
     */
    protected function getProducts(
        ProductRepository $productRepository,
        Request $request,
        PaginatorInterface $paginator,
        int $page
    ): PaginationInterface
    {
        $productsQuery = $productRepository
            ->addStatusCondition($productRepository->defineFindAllQuery(), Product::STATUS_APPROVED);
        if ($substring = $request->query->get('substring')) {
            $productsQuery = $productRepository->addSubstringCondition($productsQuery, $substring);
        }
        if ($categoryId = $request->query->get('categoryId')) {
            $productsQuery = $productRepository->addCategoryIdCondition($productsQuery, $categoryId);
        }

        return $paginator->paginate(
            $productsQuery,
            $page
        );
    }

    /**
     * Return sort items for products
     *
     * @param Request $request
     *
     * @return array
     */
    protected function getSortItems(Request $request): array
    {
        $direction = $request->query->get('direction');

        return [
            [
                'title' => 'Name' . ' ' . ($direction === 'desc' ? 'Z-A' : 'A-Z'),
                'field' => 'p.name'
            ],
            [
                'title' => 'Price' . ' ' . ($direction === 'desc' ? 'High-Low' : 'Low-High'),
                'field' => 'p.price.amount'
            ]
        ];
    }
}