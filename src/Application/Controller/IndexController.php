<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Core\Controller\AbstractApplicationController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractApplicationController
{
    #[Route(path: '/', name: 'app_index', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        return $this->renderTemplate('Core/index', ['title' => 'Home']);
    }
}
