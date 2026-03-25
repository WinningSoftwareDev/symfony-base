<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Classes\Installer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:install')]
class SetupCommand extends Command
{
    protected static string $defaultName = 'app:setup';

    protected function configure(): void
    {
        $this
            ->setName('app:setup')
            ->setDescription('Sets up the Symfony Base project')
            ->setHelp('This command helps you set up your Symfony Base project with custom project name and package information.');
    }

    /**
     * @throws \JsonException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->writeln('');
        $io->writeln('<fg=blue;options=bold>╔════════════════════════════════════════╗</>');
        $io->writeln('<fg=blue;options=bold>║       Symfony Base Project Setup       ║</>');
        $io->writeln('<fg=blue;options=bold>╚════════════════════════════════════════╝</>');
        $io->writeln('');

        $installer = new Installer($io);
        $installer->install();

        return Command::SUCCESS;
    }
}
