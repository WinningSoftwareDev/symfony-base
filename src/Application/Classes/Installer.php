<?php

declare(strict_types=1);

namespace App\Application\Classes;

use Symfony\Component\Console\Style\SymfonyStyle;

final readonly class Installer
{
    public function __construct(private SymfonyStyle $io)
    {
    }

    /**
     * @throws \JsonException
     */
    public function install(): void
    {
        $projectName = $this->io->ask('<fg=yellow>Enter your project name:</>', 'My Symfony App');
        $packageName = $this->io->ask('<fg=yellow>Enter your composer package name (vendor/package):</>', 'myvendor/myproject', function (string $answer) {
            if (!preg_match('/^[a-z0-9\-]+\/[a-z0-9\-]+$/', $answer)) {
                $answer = 'myvendor/myproject';
            }

            return $answer;
        });

        if (!is_string($projectName) || !is_string($packageName)) {
            $this->io->error('Project name was not in the expected format.');
            exit(1);
        }

        $this->updateEnvFile($projectName);
        $this->updateComposerJson($projectName, $packageName);
        $this->setupViteConfig($projectName);
        $this->showSuccessMessage($projectName, $packageName);
        $this->cleanupSetupFiles();
    }

    private function updateEnvFile(string $projectName): void
    {
        $envFile = __DIR__ . '/../../../.env';

        if (!file_exists($envFile)) {
            $this->io->error('Error: .env file not found!');
            exit(1);
        }

        $envContent = file_get_contents($envFile);

        if (!is_string($envContent)) {
            $this->io->error('Error: .env content was not readable!');
            exit(1);
        }

        $envContent = preg_replace(
            '/^APP_NAME=.*$/m',
            'APP_NAME="' . addslashes($projectName) . '"',
            $envContent
        );

        if (!is_string($envContent)) {
            $this->io->error('Error: .env content was not readable!');
            exit(1);
        }

        $envContent = preg_replace(
            '/^MAIL_FROM_NAME=.*$/m',
            'MAIL_FROM_NAME="' . addslashes($projectName) . '"',
            $envContent
        );
        file_put_contents($envFile, $envContent);
    }

    /**
     * @throws \JsonException
     */
    private function updateComposerJson(string $projectName, string $packageName): void
    {
        $composerFile = sprintf('%s/composer.json', dirname(__FILE__, 3));

        if (!file_exists($composerFile)) {
            $this->io->error('Error: composer.json file not found!');

            return;
        }

        $composerContent = file_get_contents($composerFile);

        if (!is_string($composerContent)) {
            $this->io->error('Error: composer.json file is not a string!');

            return;
        }

        $composerData = json_decode($composerContent, true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($composerData)) {
            $this->io->error('Error: composer.json content is not an array!');

            return;
        }

        $composerData['name'] = $packageName;
        $composerData['description'] = $projectName;
        $composerData['version'] = '1.0.0';

        if (is_array($composerData['scripts']) && isset($composerData['scripts']['post-create-project-cmd'])) {
            unset($composerData['scripts']['post-create-project-cmd']);
        }

        file_put_contents($composerFile, json_encode($composerData, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
    }

    private function showSuccessMessage(string $projectName, string $packageName): void
    {
        $this->io->writeln('');
        $this->io->writeln('<fg=green;options=bold>✓ Project created successfully!</>');
        $this->io->writeln("<fg=green>✓ APP_NAME set to: {$projectName}</>");
        $this->io->writeln("<fg=green>✓ Composer package set to: {$packageName}</>");
        $this->io->writeln('<fg=green>✓ Version set to: 1.0.0</>');
        $this->io->writeln('');
        $this->io->writeln('<fg=gray>Happy coding! 🚀</>');
        $this->io->writeln('');
    }

    private function cleanupSetupFiles(): void
    {
        $setupScript = sprintf('%s/bin/setup', dirname(__FILE__, 3));
        $envTemplate = sprintf('%s/.env.template', dirname(__FILE__, 3));
        $readme = sprintf('%s/README.md', dirname(__FILE__, 3));
        $changelog = sprintf('%s/CHANGELOG.md', dirname(__FILE__, 3));
        $changelogTemplate = sprintf('%s/CHANGELOG.template.md', dirname(__FILE__, 3));

        if (file_exists($readme)) {
            unlink($readme);
        }

        if (file_exists($changelog)) {
            unlink($changelog);
        }

        if (file_exists($envTemplate)) {
            unlink($envTemplate);
        }

        if (file_exists($setupScript)) {
            unlink($setupScript);
        }

        if (file_exists($changelogTemplate)) {
            rename($changelogTemplate, $changelog);
        }
    }

    private function setupViteConfig(string $projectName): void
    {
        $templateFile = sprintf('%s/vite.config.template.ts', dirname(__FILE__, 3));
        $configFile = sprintf('%s/vite.config.ts', dirname(__FILE__, 3));

        if (!file_exists($templateFile)) {
            $this->io->error('Error: vite.config.template.ts file not found!');

            return;
        }

        if (!copy($templateFile, $configFile)) {
            $this->io->error('Error: Failed to copy vite.config.template.ts to vite.config.ts!');

            return;
        }

        $configContent = file_get_contents($configFile);

        if (!is_string($configContent)) {
            $this->io->error('Error: vite.config.ts content was not readable!');

            return;
        }

        $configContent = str_replace('{APP_NAME}', strtolower(str_replace(' ', '-', $projectName)), $configContent);
        file_put_contents($configFile, $configContent);

        $gitignoreFilePath = sprintf('%s/.gitignore', dirname(__FILE__, 3));

        if (file_exists($gitignoreFilePath)) {
            $gitignoreContent = file_get_contents($gitignoreFilePath);

            if (is_string($gitignoreContent)) {
                $gitignoreContent = str_replace('/vite.config.ts', '', $gitignoreContent);
                file_put_contents($gitignoreFilePath, $gitignoreContent);
            }
        }
    }
}
