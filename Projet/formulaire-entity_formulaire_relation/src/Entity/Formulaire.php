<?php

namespace App\Entity;

use App\Repository\FormulaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormulaireRepository::class)]
class Formulaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Questions::class, inversedBy: 'formulaires')]
    private Collection $question;

    #[ORM\OneToMany(targetEntity: Reponses::class, mappedBy: 'formulaire')]
    private Collection $reponse;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Users $user = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    public function __construct()
    {
        $this->question = new ArrayCollection();
        $this->reponse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Questions>
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(Questions $question): static
    {
        if (!$this->question->contains($question)) {
            $this->question->add($question);
        }

        return $this;
    }

    public function removeQuestion(Questions $question): static
    {
        $this->question->removeElement($question);

        return $this;
    }

    /**
     * @return Collection<int, Reponses>
     */
    public function getReponse(): Collection
    {
        return $this->reponse;
    }

    public function addReponse(Reponses $reponse): static
    {
        if (!$this->reponse->contains($reponse)) {
            $this->reponse->add($reponse);
            $reponse->setFormulaire($this);
        }

        return $this;
    }

    public function removeReponse(Reponses $reponse): static
    {
        if ($this->reponse->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getFormulaire() === $this) {
                $reponse->setFormulaire(null);
            }
        }

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }
}
