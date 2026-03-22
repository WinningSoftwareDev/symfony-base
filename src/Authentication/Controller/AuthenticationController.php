<?php

declare(strict_types=1);

namespace App\Authentication\Controller;

use App\_Core\Controller\AbstractApplicationController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthenticationController extends AbstractApplicationController
{
    #[Route('/authenticate', name: 'authenticate')]
    public function authenticate(): Response
    {
        return $this->renderTemplate(
            'Authentication/authenticate',
            [
                'title' => 'Authenticate',
            ]
        );
    }
}