<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Header controller
 */
class HeaderController extends AbstractController
{
    /**
     * Index
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('header/index.html.twig',
            [
                'user' => $this->getUser()
            ]
        );
    }
}