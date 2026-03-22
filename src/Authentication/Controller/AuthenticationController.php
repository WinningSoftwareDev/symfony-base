<?php

declare(strict_types=1);

namespace App\Authentication\Controller;

use App\_Core\Controller\AbstractApplicationController;
use App\Authentication\Form\RegistrationForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthenticationController extends AbstractApplicationController
{
    #[Route('/authenticate', name: 'authenticate')]
    public function authenticate(Request $request): Response
    {
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
}