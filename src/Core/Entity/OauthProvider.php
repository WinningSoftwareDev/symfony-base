<?php

declare(strict_types=1);

namespace App\Core\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'ublOauthProvider', schema: 'Core')]
class OauthProvider
{
    public const string GITHUB = 'github';
    public const string GOOGLE = 'google';

    #[Id]
    #[GeneratedValue]
    #[Column(name: 'intOauthProviderId', type: 'integer', options: ['unsigned' => true])]
    protected ?int $id = null;

    #[Column(name: 'strOauthProviderHandle', type: 'string', length: 32)]
    protected string $handle;

    #[Column(name: 'strOauthProviderLabel', type: 'string', length: 100)]
    protected string $label;

    #[Column(name: 'strIcon', type: 'string', length: 100, nullable: true)]
    protected ?string $icon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }
}
