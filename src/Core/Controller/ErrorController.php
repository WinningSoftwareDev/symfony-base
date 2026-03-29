<?php

declare(strict_types=1);

namespace App\Core\Controller;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends AbstractApplicationController
{
    public function showErrorPage(FlattenException $exception): Response
    {
        $statusCode = $exception->getStatusCode();
        $page = match ($statusCode) {
            Response::HTTP_INTERNAL_SERVER_ERROR => '500',
            Response::HTTP_FORBIDDEN => '403',
            default => '404',
        };
        $pageTitle = match ($statusCode) {
            Response::HTTP_INTERNAL_SERVER_ERROR => 'Server Error',
            Response::HTTP_FORBIDDEN => 'Access Denied',
            default => 'Page Not Found',
        };

        return $this->renderTemplate(sprintf('Core/Error/%s', $page), [
            'title' => $pageTitle,
        ]);
    }
}
