<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Create test data controller
 *
 * @Route("/create/test")
 */
class CreateTestDataController extends AbstractController
{
    /**
     * Create test admin user
     *
     * @param UserRepository $userRepository
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @Route("/admin", name="app_create_test_admin")
     *
     * @return RedirectResponse
     */
    public function createAdmin(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): RedirectResponse
    {
        $email = 'admin@example.com';
        $password = 'example';

        if (!$userRepository->findOneBy(['email' => $email])) {
            $user = new User();
            $user->setEmail($email)
                ->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $password
                    )
                )
                ->setRoles(['ROLE_ADMIN']);
            $userRepository->add($user);
        }
        $this->addFlash(
            'success',
            'Test admin created: ' . $email . ' / ' . $password
        );

        return $this->redirectToRoute('app_home');
    }
}