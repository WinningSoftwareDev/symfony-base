<?php

declare(strict_types=1);

namespace App\Authentication\Entity;

use App\Authentication\Interface\SimpleEntityInterface;
use App\Core\Entity\AbstractBaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tblRole', schema: 'Authentication')]
class Role extends AbstractBaseEntity implements SimpleEntityInterface
{
    public const string ROLE_ADMIN = 'ROLE_ADMIN';
    public const string ROLE_USER = 'ROLE_USER';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'intRoleId', type: 'integer', options: ['unsigned' => true])]
    protected ?int $id = null;

    #[ORM\Column(name: 'strRoleName', length: 50, unique: true, nullable: false)]
    private string $name;

    #[ORM\Column(name: 'strHandle', length: 50, unique: true, nullable: false)]
    private string $handle;

    /**
     * @var Collection<int, Permission>
     */
    #[ORM\ManyToMany(targetEntity: Permission::class)]
    #[ORM\JoinTable(name: 'tblRolePermission', schema: 'Authentication')]
    #[ORM\JoinColumn(name: 'intRoleId', referencedColumnName: 'intRoleId')]
    #[ORM\InverseJoinColumn(name: 'intPermissionId', referencedColumnName: 'intPermissionId')]
    private Collection $permissions;

    public function __construct()
    {
        $this->permissions = new ArrayCollection();
    }

    public static function create(string $name, string $handle): self
    {
        $role = new self();
        $role->name = $name;
        $role->handle = $handle;

        return $role;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    /**
     * @return Collection<int, Permission>
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(Permission $permission): void
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions->add($permission);
        }
    }

    public function removePermission(Permission $permission): void
    {
        $this->permissions->removeElement($permission);
    }
}
