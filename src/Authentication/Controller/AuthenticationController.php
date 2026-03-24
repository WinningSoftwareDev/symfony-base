<?php

declare(strict_types=1);

namespace App\Authentication\Controller;

use App\_Core\Controller\AbstractApplicationController;
use App\Authentication\Entity\User;
use App\Authentication\Form\RegistrationForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthenticationController extends AbstractApplicationController
{
    #[Route('/authenticate', name: 'authenticate')]
    public function authenticate(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_index');
        }

        $tab = $request->query->get('form') ?? 'false';

        if ($tab && !in_array($tab, ['LoginForm', 'RegistrationForm'])) {
            $tab = 'false';
        }

        return $this->renderTemplate(
            'Authentication/authenticate',
            [
                'title' => 'Authenticate',
                'form' => $tab,
            ]
        );
    }

    #[Route('/authenticate/password-reset', name: 'authenticate_password_reset')]
    public function forgotPassword(): Response
    {
        return $this->renderTemplate(
            'Authentication/password-reset',
            [
                'title' => 'Password Reset',
            ]
        );
    }

    #[Route('/authenticate/current-user', name: 'get_logged_in_user')]
    public function getLoggedInUser(): Response
    {
        $user = $this->getUser();

        if ($user instanceof User) {
            return $this->json(['email' => $user->getEmail(), 'verified' => $user->isVerified()]);
        }

        return $this->json([
            'email' => '',
            'verified' => false,
        ]);
    }
}