<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $id_reponse = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $lastname = null;

    #[ORM\ManyToMany(targetEntity: users::class)]
    private Collection $questions;

    #[ORM\ManyToMany(targetEntity: Users::class, mappedBy: 'reponses')]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: Users::class, mappedBy: 'reponses')]
    private Collection $id_user;

    #[ORM\OneToMany(targetEntity: UserReponse::class, mappedBy: 'user')]
    private Collection $userReponses;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->id_user = new ArrayCollection();
        $this->userReponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReponsesId(): ?int
    {
        return $this->id_reponse;
    }

    public function setReponsesId(?int $id_reponse): static
    {
        $this->id_reponse = $id_reponse;

        return $this;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
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

    /**
     * @return Collection<int, users>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(users $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    public function removeQuestion(users $question): static
    {
        $this->questions->removeElement($question);

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addReponse($this);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeReponse($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getIdUser(): Collection
    {
        return $this->id_user;
    }

    public function addIdUser(Users $idUser): static
    {
        if (!$this->id_user->contains($idUser)) {
            $this->id_user->add($idUser);
            $idUser->addReponse($this);
        }

        return $this;
    }

    public function removeIdUser(Users $idUser): static
    {
        if ($this->id_user->removeElement($idUser)) {
            $idUser->removeReponse($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, UserReponse>
     */
    public function getUserReponses(): Collection
    {
        return $this->userReponses;
    }

    public function addUserReponse(UserReponse $userReponse): static
    {
        if (!$this->userReponses->contains($userReponse)) {
            $this->userReponses->add($userReponse);
            $userReponse->setUser($this);
        }

        return $this;
    }

    public function removeUserReponse(UserReponse $userReponse): static
    {
        if ($this->userReponses->removeElement($userReponse)) {
            // set the owning side to null (unless already changed)
            if ($userReponse->getUser() === $this) {
                $userReponse->setUser(null);
            }
        }

        return $this;
    }
}
