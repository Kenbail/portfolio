<?php

namespace App\Entity;

use App\Repository\UserReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserReponseRepository::class)]
class UserReponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $reponse_user = null;

    #[ORM\ManyToOne(inversedBy: 'userReponses')]
    private ?Users $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReponseUser(): ?string
    {
        return $this->reponse_user;
    }

    public function setReponseUser(string $reponse_user): static
    {
        $this->reponse_user = $reponse_user;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }
}
