<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 20)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $budget = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $activity = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $food = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBudget(): array
    {
        return $this->budget;
    }

    public function setBudget(array $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getActivity(): array
    {
        return $this->activity;
    }

    public function setActivity(array $activity): static
    {
        $this->activity = $activity;

        return $this;
    }

    public function getFood(): array
    {
        return $this->food;
    }

    public function setFood(array $food): static
    {
        $this->food = $food;

        return $this;
    }
}
