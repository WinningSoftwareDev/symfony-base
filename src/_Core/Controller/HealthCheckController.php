<?php

declare(strict_types=1);

namespace App\_Core\Controller;

use App\Authentication\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HealthCheckController extends AbstractApplicationController
{
    #[Route('/health-check/database-connection', name: 'app_health_check_database_connection')]
    public function checkDatabaseConnection(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->getConnection()->executeQuery('SELECT 1');

            return $this->json([
                'message' => 'Database connection successful',
                'success' => true,
            ]);
        } catch (\Throwable $e) {
            return $this->json([
                'message' => 'Database connection error, please check your configuration.',
                'success' => false,
            ]);
        }
    }

    #[Route('/health-check/default-tables-exist', name: 'app_health_check_default_tables_exist')]
    public function checkDefaultTablesExist(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->getRepository(User::class)->findAll();

            return $this->json([
                'message' => 'Default database tables exist',
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Default tables do not exist. Please run the database setup script at data/setup.sql',
                'success' => false,
            ]);
        }
    }

    #[Route('/health-check/php-version', name: 'app_health_check_php_version')]
    public function checkPHPVersion(): Response
    {
        $phpVersion = PHP_VERSION;

        return $this->json([
            'message' => 'PHP version is ' . $phpVersion,
            'success' => (float) $phpVersion >= 8.4,
        ]);
    }

    /**
     * @throws \JsonException
     */
    #[Route('/health-check/symfony-version', name: 'app_health_check_symfony_version')]
    public function checkSymfonyVersion(): Response
    {
        $path = sprintf('%s/composer.json', dirname(__DIR__, 3));
        $composerContents = file_get_contents($path);

        if (!$composerContents) {
            return $this->json([
                'message' => 'Composer.json is empty',
                'success' => false,
            ]);
        }

        $composerJson = json_decode($composerContents, true, 512, JSON_THROW_ON_ERROR);
        $symfonyVersion = (float) $composerJson['require']['symfony/console'];

        return $this->json([
            'message' => 'Symfony version is ' . (string) $symfonyVersion,
            'success' => (float) $symfonyVersion >= 7.3,
        ]);
    }
}
