<?php

declare(strict_types=1);

namespace App\Administration\Controller;

use App\Core\Controller\AbstractApplicationController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/admin')]
class DashboardController extends AbstractApplicationController
{
    #[Route(path: '/', name: 'dashboard')]
    public function dashboard(): Response
    {
        return $this->renderTemplate('Administration/index', []);
    }
}