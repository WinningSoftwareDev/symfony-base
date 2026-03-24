<?php

declare(strict_types=1);

namespace App\_Core\Controller;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends AbstractApplicationController
{
    public function showErrorPage(FlattenException $exception): Response
    {
        $statusCode = $exception->getStatusCode();
        $page = match ($statusCode) {
            Response::HTTP_INTERNAL_SERVER_ERROR => '500',
            default => '404',
        };
        $pageTitle = match ($statusCode) {
            Response::HTTP_INTERNAL_SERVER_ERROR => 'Server Error',
            default => 'Page Not Found',
        };

        return $this->renderTemplate(sprintf('Core/Error/%s', $page), [
            'title' => $pageTitle,
        ]);
    }
}