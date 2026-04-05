<?php

declare(strict_types=1);

namespace App\Administration\Controller\API;

use App\Authentication\Entity\User;
use App\Authentication\Repository\UserRepository;
use App\Core\Controller\AbstractApplicationController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractApplicationController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/api/admin/users', methods: ['GET'])]
    public function listAll(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 1);
        $search = $request->query->get('search');

        /**
         * @var UserRepository $userRepository
         */
        $userRepository = $this->entityManager->getRepository(User::class);
        $paginator = $userRepository->getPaginatedUsers($page, $limit, $search);
        $totalItems = count($paginator);
        $pagesCount = (int) ceil($totalItems / $limit);

        $users = [];

        foreach ($paginator as $user) {
            $users[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
                // Add a formatted date if you have a createdAt field
                // 'createdAt' => $user->getCreatedAt()?->format('Y-m-d H:i'),
            ];
        }

        return $this->json([
            'data' => $users,
            'meta' => [
                'current_page' => $page,
                'last_page' => $pagesCount,
                'per_page' => $limit,
                'total' => $totalItems,
            ],
        ]);
    }
}
