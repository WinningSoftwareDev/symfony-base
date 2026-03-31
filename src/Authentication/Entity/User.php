<?php

declare(strict_types=1);

namespace App\Authentication\Entity;

use App\Authentication\Classes\DTO\RegistrationDTO;
use App\Core\Entity\AbstractBaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'tblUser', schema: 'Authentication')]
class User extends AbstractBaseEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'intUserId', type: 'integer', options: ['unsigned' => true])]
    protected ?int $id = null;

    #[ORM\Column(name: 'strEmail', length: 180, unique: true, nullable: false)]
    private string $email;

    #[ORM\Column(name: 'strPassword', length: 255, nullable: false, options: ['comment' => 'Hashed password'])]
    private string $password;

    #[ORM\Column(name: 'bolActive', type: 'boolean', nullable: false)]
    private bool $isActive = true;

    #[ORM\Column(name: 'bolVerified', type: 'boolean', nullable: false)]
    private bool $isVerified = false;

    /**
     * @var Collection<int, Role>
     */
    #[ORM\ManyToMany(targetEntity: Role::class)]
    #[ORM\JoinTable(name: 'tblUserRole', schema: 'Authentication')]
    #[ORM\JoinColumn(name: 'intUserId', referencedColumnName: 'intUserId')]
    #[ORM\InverseJoinColumn(name: 'intRoleId', referencedColumnName: 'intRoleId')]
    private Collection $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public static function create(RegistrationDTO $dto, UserPasswordHasherInterface $passwordHasher): self
    {
        $user = new self();

        $user->setEmail($dto->getEmail());
        $user->setPassword($passwordHasher->hashPassword($user, $dto->getPassword()));

        return $user;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @see UserInterface
     *
     * @throws \RuntimeException
     */
    public function getUserIdentifier(): string
    {
        if (empty($this->email)) {
            throw new \RuntimeException('Email is empty');
        }

        return $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles->map(fn (Role $role) => $role->getHandle())->toArray();
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRoleObjects(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): void
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }
    }

    public function removeRole(Role $role): void
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function deactivate(): void
    {
        $this->isActive = false;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function verify(): void
    {
        $this->isVerified = true;
    }

    public function unverify(): void
    {
        $this->isVerified = false;
    }

    public function eraseCredentials(): void
    {
    }
}
