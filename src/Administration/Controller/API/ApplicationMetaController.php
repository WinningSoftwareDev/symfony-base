<?php

declare(strict_types=1);

namespace App\Administration\Controller\API;

use App\Core\Controller\AbstractApplicationController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ApplicationMetaController extends AbstractApplicationController
{
    #[Route(path: '/api/admin/app-meta', name: 'api_admin_app_meta', methods: ['GET'])]
    public function getAppMeta(): JsonResponse
    {
        return $this->json([
            'name' => $this->getApp()->getEnvironmentOption('APP_NAME'),
            'currentUser' => $this->getUser()?->jsonSerialize(),
        ]);
    }
}
