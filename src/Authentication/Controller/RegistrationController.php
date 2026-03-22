<?php

declare(strict_types=1);

namespace App\Authentication\Controller;

use App\_Core\Controller\AbstractApplicationController;
use App\Authentication\Classes\DTO\RegistrationDTO;
use App\Authentication\Classes\Email\EmailVerificationService;
use App\Authentication\Entity\User;
use App\Authentication\Form\RegistrationForm;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractApplicationController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws TransportExceptionInterface|RandomException
     */
    #[Route('/auth/register', name: 'auth_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EmailVerificationService $verificationService
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_index');
        }

        $data = new RegistrationDTO();
        $form = $this->createForm(RegistrationForm::class, $data);
        $form->handleRequest($request);

        dd($form->isSubmitted());
        if ($form->isSubmitted()) {
            $existingUser = $this->entityManager
                ->getRepository(User::class)
                ->findOneBy(['email' => $data->getEmail()]);
            $data->setUserExists($existingUser instanceof User);

            if ($form->isValid() && $data->validate()) {
                $user = User::create($data, $passwordHasher);

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $verificationService->sendVerificationEmail($user);

                $this->addFlash('success', 'Account created. You can now log in.');

                return $this->redirectToRoute('auth_login');
            }
        }

        return $this->renderTemplate('_core/pages/auth/register.latte', [
            'data' => $data,
            'form' => $form->createView(),
            'title' => 'Register',
        ]);
    }
}
