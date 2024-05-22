<?php

namespace App\Entity;

use App\Repository\ReponsesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponsesRepository::class)]
class Reponses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse = null;

    #[ORM\Column]
    private ?int $id_question = null;

    #[ORM\Column]
    private ?int $id_user = null;

    #[ORM\Column(length: 255)]
    private ?string $balises = null;

    #[ORM\Column(length: 255)]
    private ?string $attribut_question = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    private ?string $type_input = null;

    #[ORM\ManyToOne(inversedBy: 'reponse')]
    private ?Formulaire $formulaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): static
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getidQuestion(): ?int
    {
        return $this->id_question;
    }

    public function setidQuestion(int $id_question): static
    {
        $this->id_question = $id_question;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getBalises(): ?string
    {
        return $this->balises;
    }

    public function setBalises(string $balises): static
    {
        $this->balises = $balises;

        return $this;
    }

    public function getAttribut_question(): ?string
    {
        return $this->attribut_question;
    }

    public function setAttribut_question(string $attribut_question): static
    {
        $this->attribut_question = $attribut_question;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getType_Input(): ?string
    {
        return $this->type_input;
    }

    public function setType_Input(string $type_input): static
    {
        $this->type_input = $type_input;

        return $this;
    }

    public function getFormulaire(): ?Formulaire
    {
        return $this->formulaire;
    }

    public function setFormulaire(?Formulaire $formulaire): static
    {
        $this->formulaire = $formulaire;

        return $this;
    }
}
