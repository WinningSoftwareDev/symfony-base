<?php

declare(strict_types=1);

namespace App\Authentication\Controller;

use App\Authentication\Entity\Role;
use App\Core\Controller\AbstractApplicationController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserAccountController extends AbstractApplicationController
{
    #[Route('/user/account', name: 'user_account')]
    #[IsGranted(Role::ROLE_USER)]
    public function dashboard(): Response
    {
        return $this->renderTemplate(
            'Authentication/UserAccount/dashboard',
            [
                'title' => 'My Account',
                'user' => $this->getUser(),
            ],
        );
    }
}
