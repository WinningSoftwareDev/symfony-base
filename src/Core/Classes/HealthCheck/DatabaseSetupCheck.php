<?php

declare(strict_types=1);

namespace App\Core\Classes\HealthCheck;

use App\Authentication\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diagnostics\Check\CheckInterface;
use Laminas\Diagnostics\Result\Failure;
use Laminas\Diagnostics\Result\ResultInterface;
use Laminas\Diagnostics\Result\Success;

readonly class DatabaseSetupCheck implements CheckInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function check(): ResultInterface
    {
        try {
            $this->entityManager->getRepository(User::class)->find(1);

            return new Success('Default database tables exist');
        } catch (\Exception $e) {
            return new Failure('Default tables do not exist. Run: bin/console app:database:setup');
        }
    }

    public function getLabel(): string
    {
        return 'Database setup';
    }
}
