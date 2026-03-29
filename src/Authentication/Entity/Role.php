<?php

declare(strict_types=1);

namespace App\Authentication\Entity;

use App\Core\Entity\AbstractBaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tblRole', schema: 'Authentication')]
class Role extends AbstractBaseEntity
{
    const string ROLE_USER = 'ROLE_USER';

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

    public function __construct(string $name, string $handle)
    {
        $this->name = $name;
        $this->handle = $handle;
        $this->permissions = new ArrayCollection();
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
