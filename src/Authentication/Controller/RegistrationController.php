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
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractApplicationController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
    ) {
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

        if ($form->isSubmitted() && $form->isValid()) {
            $existingUser = $this->entityManager
                ->getRepository(User::class)
                ->findOneBy(['email' => $data->getEmail()]);
            $data->setUserExists($existingUser instanceof User);

            $errors = $this->validator->validate($data);

            if (!$data->validate() || count($errors)) {
                return $this->json([
                    'success' => false,
                    'errors' => $this->getValidationErrors($data, $errors),
                ]);
            }

            $user = User::create($data, $passwordHasher);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $verificationService->sendVerificationEmail($user);

            $this->addFlash('success', 'Account created. You can now log in.');

            return $this->json([
                'success' => true,
                'errors' => [],
                'redirect' => $this->generateUrl('authenticate', ['form' => 'LoginForm']),
            ]);
        }

        return $this->redirectToRoute('app_index');
    }

    /**
     * @return array<string, array<int, string|\Stringable>>
     */
    private function getValidationErrors(RegistrationDTO $data, ConstraintViolationListInterface $errors): array
    {
        $validationErrors = [];

        foreach ($errors as $error) {
            $validationErrors[$error->getPropertyPath()][] = $error->getMessage();
        }

        if (!$data->passwordsMatch()) {
            $validationErrors['confirmPassword'][] = 'Passwords do not match.';
        }

        if ($data->userExists()) {
            $validationErrors['email'][] = 'A user with this email address already exists.';
        }

        return $validationErrors;
    }
}
