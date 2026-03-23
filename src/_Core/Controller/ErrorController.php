<?php

declare(strict_types=1);

namespace App\_Core\Controller;

use Symfony\Component\HttpFoundation\Response;

class ErrorController extends AbstractApplicationController
{
    public function pageNotFound(): Response
    {
        return $this->renderTemplate('_core/404', [
            'title' => 'Page not found',
        ]);
    }
}