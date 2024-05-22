<?php

namespace App\Entity;

use App\Repository\QuestionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionsRepository::class)]
class Questions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'question')]
    private ?Reponses $reponses = null;

    #[ORM\ManyToMany(targetEntity: Formulaire::class, mappedBy: 'question')]
    private Collection $formulaires;

    public function __construct()
    {
        $this->formulaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getReponses(): ?Reponses
    {
        return $this->reponses;
    }

    public function setReponses(?Reponses $reponses): static
    {
        $this->reponses = $reponses;

        return $this;
    }

    /**
     * @return Collection<int, Formulaire>
     */
    public function getFormulaires(): Collection
    {
        return $this->formulaires;
    }

    public function addFormulaire(Formulaire $formulaire): static
    {
        if (!$this->formulaires->contains($formulaire)) {
            $this->formulaires->add($formulaire);
            $formulaire->addQuestion($this);
        }

        return $this;
    }

    public function removeFormulaire(Formulaire $formulaire): static
    {
        if ($this->formulaires->removeElement($formulaire)) {
            $formulaire->removeQuestion($this);
        }

        return $this;
    }
}
