<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $diplome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modeFormation = null;

    #[ORM\Column(nullable: true)]
    private ?float $coutMin = null;

    #[ORM\Column(nullable: true)]
    private ?float $coutMax = null;

    #[ORM\Column(nullable: true)]
    private ?int $page = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToMany(targetEntity: DomaineFormation::class, mappedBy: 'formations')]
    private Collection $domainesFormation;

    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'formation')]
    private Collection $avis;

    #[ORM\ManyToOne(targetEntity: Ecole::class, inversedBy: 'formations')]
    private ?Ecole $ecole = null;

    #[ORM\OneToMany(targetEntity: NiveauFormation::class, mappedBy: 'formation')]
    private Collection $niveaux;

    public function __construct()
    {
        $this->domainesFormation = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(?string $diplome): static
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getModeFormation(): ?string
    {
        return $this->modeFormation;
    }

    public function setModeFormation(?string $modeFormation): static
    {
        $this->modeFormation = $modeFormation;

        return $this;
    }

    public function getCoutMin(): ?float
    {
        return $this->coutMin;
    }

    public function setCoutMin(?float $coutMin): static
    {
        $this->coutMin = $coutMin;

        return $this;
    }

    public function getCoutMax(): ?float
    {
        return $this->coutMax;
    }

    public function setCoutMax(?float $coutMax): static
    {
        $this->coutMax = $coutMax;

        return $this;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(?int $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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
            $domaineFormation->addFormation($this);
        }

        return $this;
    }

    public function removeDomaineFormation(DomaineFormation $domaineFormation): static
    {
        if ($this->domainesFormation->removeElement($domaineFormation)) {
            $domaineFormation->removeFormation($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setFormation($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            if ($avi->getFormation() === $this) {
                $avi->setFormation(null);
            }
        }

        return $this;
    }

    public function getEcole(): ?Ecole
    {
        return $this->ecole;
    }

    public function setEcole(?Ecole $ecole): static
    {
        $this->ecole = $ecole;

        return $this;
    }

    /**
     * @return Collection<int, NiveauFormation>
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(NiveauFormation $niveau): static
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux->add($niveau);
            $niveau->setFormation($this);
        }

        return $this;
    }

    public function removeNiveau(NiveauFormation $niveau): static
    {
        if ($this->niveaux->removeElement($niveau)) {
            if ($niveau->getFormation() === $this) {
                $niveau->setFormation(null);
            }
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
