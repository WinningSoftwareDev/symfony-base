<?php

declare(strict_types=1);

namespace App\Authentication\Controller;

use App\_Core\Controller\AbstractApplicationController;
use App\Authentication\Form\LoginForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractApplicationController
{
    #[Route('/auth/login', name: 'auth_login')]
    public function login(): Response
    {
        return $this->redirectToRoute('authenticate', ['form' => 'LoginForm']);
    }

    #[Route('/auth/logout', name: 'auth_logout')]
    public function logout(): void
    {
        throw new \LogicException('Logout is handled by the firewall.');
    }
}
