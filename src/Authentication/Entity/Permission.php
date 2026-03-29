<?php

declare(strict_types=1);

namespace App\Authentication\Entity;

use App\Authentication\Interface\SimpleEntityInterface;
use App\Core\Entity\AbstractBaseEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tblPermission', schema: 'Authentication')]
class Permission extends AbstractBaseEntity implements SimpleEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'intPermissionId', type: 'integer', options: ['unsigned' => true])]
    protected ?int $id = null;

    #[ORM\Column(name: 'strPermissionName', length: 50, unique: true, nullable: false)]
    private string $name;

    #[ORM\Column(name: 'strHandle', length: 50, unique: true, nullable: false)]
    private string $handle;

    public static function create(string $name, string $handle): self
    {
        $permission = new self();
        $permission->name = $name;
        $permission->handle = $handle;

        return $permission;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHandle(): string
    {
        return $this->handle;
    }
}
