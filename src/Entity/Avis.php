<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private ?string $avis = null;

    #[ORM\Column(nullable: true)]
    private ?float $noteEnseignement = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(nullable: true)]
    private ?float $noteGlobale = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $modere = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(targetEntity: Formation::class, inversedBy: 'avis')]
    private ?Formation $formation = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'avis')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: DomaineFormation::class, mappedBy: 'avis')]
    private Collection $domainesFormation;

    public function __construct()
    {
        $this->domainesFormation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function setAvis(string $avis): static
    {
        $this->avis = $avis;

        return $this;
    }

    public function getNoteEnseignement(): ?float
    {
        return $this->noteEnseignement;
    }

    public function setNoteEnseignement(?float $noteEnseignement): static
    {
        $this->noteEnseignement = $noteEnseignement;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNoteGlobale(): ?float
    {
        return $this->noteGlobale;
    }

    public function setNoteGlobale(?float $noteGlobale): static
    {
        $this->noteGlobale = $noteGlobale;

        return $this;
    }

    public function isModere(): ?bool
    {
        return $this->modere;
    }

    public function setModero(?bool $modere): static
    {
        $this->modere = $modere;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, DomaineFormation>
     */
    public function getDomainesFormation(): Collection
    {
        return $this->domainesFormation;
    }

    public function addDomaineFormation(DomaineFormation $domaineFormation): static
    {
        if (!$this->domainesFormation->contains($domaineFormation)) {
            $this->domainesFormation->add($domaineFormation);
            $domaineFormation->addAvi($this);
        }

        return $this;
    }

    public function removeDomaineFormation(DomaineFormation $domaineFormation): static
    {
        if ($this->domainesFormation->removeElement($domaineFormation)) {
            $domaineFormation->removeAvi($this);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
