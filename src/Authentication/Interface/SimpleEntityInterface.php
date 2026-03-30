<?php

declare(strict_types=1);

namespace App\Authentication\Interface;

interface SimpleEntityInterface
{
    public static function create(string $name, string $handle): self;

    public function getName(): string;

    public function getHandle(): string;
}
