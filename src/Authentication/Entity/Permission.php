<?php

declare(strict_types=1);

namespace App\Authentication\Entity;

use App\Core\Entity\AbstractBaseEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tblPermission', schema: 'Authentication')]
class Permission extends AbstractBaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'intPermissionId', type: 'integer', options: ['unsigned' => true])]
    protected ?int $id = null;

    #[ORM\Column(name: 'strPermissionName', length: 50, unique: true, nullable: false)]
    private string $name;

    #[ORM\Column(name: 'strHandle', length: 50, unique: true, nullable: false)]
    private string $handle;

    public function __construct(string $name, string $handle)
    {
        $this->name = $name;
        $this->handle = $handle;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function setHandle(string $handle): void
    {
        $this->handle = $handle;
    }
}
