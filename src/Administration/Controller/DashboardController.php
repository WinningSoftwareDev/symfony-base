<?php

declare(strict_types=1);

namespace App\Administration\Controller;

use App\Core\Controller\AbstractApplicationController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractApplicationController
{
    #[Route('/admin/{vue_routing}', name: 'admin_entry', requirements: ['vue_routing' => '.*'])]
    public function admin(): Response
    {
        return $this->renderTemplate('Administration/index', [
            'title' => 'Dashboard',
        ]);
    }
}
