<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use App\Form\ProductFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Product\ImageHandler;

/**
 * User products controller
 */
class UserProductsController extends AbstractController
{
    /**
     * Index
     *
     * @Route("/user/products/{page<\d+>}", name="app_user_products")
     * @param ProductRepository $productRepository
     * @param PaginatorInterface $paginator
     * @param int $page
     *
     * @return Response
     */
    public function index(ProductRepository $productRepository, PaginatorInterface $paginator, int $page = 1): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('user/products/index.html.twig',
            [
                'products' => $this->getProductsUser($productRepository, $paginator, $page, $user->getId()),
                'isUserExperience' => true
            ]
        );
    }

    /**
     * Get products user
     *
     * @param ProductRepository $productRepository
     * @param PaginatorInterface $paginator
     * @param int $page
     * @param int $userId
     *
     * @return PaginationInterface
     */
    protected function getProductsUser(
        ProductRepository $productRepository,
        PaginatorInterface $paginator,
        int $page,
        int $userId
    ): PaginationInterface
    {
        return $paginator->paginate(
            $productRepository->defineFindByUserIdQuery($userId),
            $page
        );
    }

    /**
     * Add action
     *
     * @Route("/user/product/add", name="app_add_user_product")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param ImageHandler $imageHandler
     *
     * @return Response
     */
    public function add(Request $request, ProductRepository $productRepository, ImageHandler $imageHandler): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(ProductFormType::class, new Product());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $data = $form->getData()) {
            if ($image = $form->get('image')->getData()) {
                $data->uploadImageProduct($image, $imageHandler);
            }
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

    /**
     * Edit action
     *
     * @Route("/user/product/edit/{id}", name="app_edit_user_product")
     * @param int $id
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param ImageHandler $imageHandler
     *
     * @return Response
     */
    public function edit(int $id, Request $request, ProductRepository $productRepository, ImageHandler $imageHandler): Response
    {
        $product = $this->getProductUser($id, $this->getUser(), $productRepository);
        if (!$product) {
            return $this->redirectToRoute('app_add_user_product');
        }

        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $data = $form->getData()) {
            if ($form->get('isRemoveImage')->getData()) {
                $data->deleteImageProduct($imageHandler);
            }
            if ($image = $form->get('image')->getData()) {
                $data->uploadImageProduct($image, $imageHandler);
            }
            $productRepository->add($data);

            $this->addFlash(
                'success',
                'Ad edited successfully'
            );
            return $this->redirectToRoute('app_user_products');
        }

        return $this->renderForm('user/product/edit.html.twig',
            [
                'form' => $form,
                'product' => $product
            ]
        );
    }

    /**
     * Get product user
     *
     * @param int $id
     * @param $user
     * @param ProductRepository $productRepository
     *
     * @return Product|null
     */
    protected function getProductUser(int $id, $user, ProductRepository $productRepository): ?Product
    {
        return $productRepository->findOneBy(['id' => $id, 'user' => $user]);
    }

    /**
     * Delete action
     *
     * @Route("/user/product/delete", name="app_delete_user_product", methods="GET")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param ImageHandler $imageHandler
     *
     * @return JsonResponse
     */
    public function delete(Request $request, ProductRepository $productRepository, ImageHandler $imageHandler): JsonResponse
    {
        $productId = $request->query->get('id');
        if ($product = $this->getProductUser($productId, $this->getUser(), $productRepository)) {
            $product->deleteImageProduct($imageHandler);
            $productRepository->remove($product);
            $this->addFlash(
                'success',
                'Ad deleted successfully'
            );
        }

        return $this->json([
            'reloadPage' => true
        ]);
    }
}