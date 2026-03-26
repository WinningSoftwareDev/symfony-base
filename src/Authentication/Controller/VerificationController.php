<?php

declare(strict_types=1);

namespace App\Authentication\Controller;

use App\_Core\Controller\AbstractApplicationController;
use App\Authentication\Classes\Email\EmailVerificationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VerificationController extends AbstractApplicationController
{
    #[Route(path: '/authenticate/verify', name: 'authenticate_verify_email', methods: [Request::METHOD_GET])]
    public function verify(Request $request, EmailVerificationService $emailVerificationService): Response
    {
        $token = $request->query->get('token');

        if (!is_string($token)) {
            $this->addFlash('error', 'Invalid verification link.');

            return $this->redirectToRoute('authenticate_login');
        }

        $user = $emailVerificationService->verifyToken($token);

        if (!$user) {
            $this->addFlash('error', 'Verification link is invalid or expired.');

            return $this->redirectToRoute('authenticate_login');
        }

        $this->addFlash('success', 'Your account is now verified. You can log in.');

        return $this->redirectToRoute('authenticate_login');
    }
}
