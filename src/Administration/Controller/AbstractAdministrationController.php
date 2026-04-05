<?php

declare(strict_types=1);

namespace App\Administration\Controller;

use App\Core\Controller\AbstractApplicationController;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractAdministrationController extends AbstractApplicationController
{
    protected function renderTemplate(string $template, array $data = []): Response
    {
        if (!array_key_exists('user', $data)) {
            $data['user'] = $this->getUser();
        }

        return parent::renderTemplate($template, $data);
    }
}
