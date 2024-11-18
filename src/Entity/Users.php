<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255,  type: 'json')]
    private array $roles = []; // No default role initially

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    // UserInterface method: returns the email as the identifier
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    // Getter for roles
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER'; // Ensure every user has at least the ROLE_USER
        return array_unique($roles);
    }

  // Setter for roles
  public function setRoles(array $roles): static
  {
      $this->roles = $roles;
      return $this;
  }

    // Empty method for salt (not needed for modern hashing)
    public function getSalt()
    {
        // Not needed with modern password hashing
    }

    // Method to erase credentials (if needed)
    public function eraseCredentials()
    {
        // Clear sensitive data if necessary
    }

    // Alias for getUserIdentifier
    public function getUsername(): string
    {
        return $this->email;
    }
}


