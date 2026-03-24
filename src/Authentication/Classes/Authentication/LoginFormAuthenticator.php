<?php

declare(strict_types=1);

namespace App\Authentication\Classes\Authentication;

use App\Authentication\Classes\DTO\LoginDTO;
use App\Authentication\Form\LoginForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    public function __construct(
        private readonly RouterInterface $router,
        private readonly FormFactoryInterface $formFactory
    ) {
    }

    public function authenticate(Request $request): Passport
    {
        $data = new LoginDTO();
        $loginForm = $this->formFactory->create(LoginForm::class, $data);

        $loginForm->handleRequest($request);

        if (!$loginForm->isSubmitted() || !$loginForm->isValid()) {
            throw new CustomUserMessageAuthenticationException('Invalid credentials');
        }

        return new Passport(
            new UserBadge($data->getEmail()),
            new PasswordCredentials($data->getPassword()),
            []
        );
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate('authenticate_login');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $flashBag = $request->getSession()->getBag('flashes');

        if ($flashBag instanceof FlashBag) {
            $flashBag->add('success', 'You have been logged in successfully.');
        }

        return new JsonResponse([
            'success' => true,
            'errors' => [],
            'redirect' => $this->router->generate('app_index'),
        ]);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $flashBag = $request->getSession()->getBag('flashes');

        if ($flashBag instanceof FlashBag) {
            $flashBag->add('error', 'Invalid credentials');
        }

        return new JsonResponse([
            'success' => false,
            'errors' => [],
        ]);
    }
}
