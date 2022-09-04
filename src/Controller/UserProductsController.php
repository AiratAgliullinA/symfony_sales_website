<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use App\Form\ProductFormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * User products controller
 */
class UserProductsController extends AbstractController
{
    /**
     * Index
     *
     * @Route("/user/products", name="app_user_products")
     *
     * @return Response
     */
    public function index(): Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('user/products/index.html.twig');
    }

    /**
     * Add action
     *
     * @Route("/user/product/add", name="app_add_user_product")
     *
     * @return Response
     */
    public function add(Request $request, ProductRepository $productRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(ProductFormType::class, new Product());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $data = $form->getData()) {
            $user->addProduct($data);
            $productRepository->add($data);

            $this->addFlash(
                'success',
                'Ad added successfully'
            );
            return $this->redirectToRoute('app_user_products');
        }

        return $this->renderForm('user/product/add.html.twig',
            ['form' => $form]
        );
    }
}