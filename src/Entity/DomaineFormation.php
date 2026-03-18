<?php

namespace App\Entity;

use App\Repository\DomaineFormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DomaineFormationRepository::class)]
class DomaineFormation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Formation::class, inversedBy: 'domainesFormation')]
    private Collection $formations;

    #[ORM\ManyToMany(targetEntity: Avis::class, inversedBy: 'domainesFormation')]
    private Collection $avis;

    #[ORM\OneToMany(targetEntity: NiveauFormation::class, mappedBy: 'domaineFormation')]
    private Collection $niveaux;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->addDomaineFormation($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): static
    {
        if ($this->formations->removeElement($formation)) {
            $formation->removeDomaineFormation($this);
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
            $avi->addDomaineFormation($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            $avi->removeDomaineFormation($this);
        }

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
            $niveau->setDomaineFormation($this);
        }

        return $this;
    }

    public function removeNiveau(NiveauFormation $niveau): static
    {
        if ($this->niveaux->removeElement($niveau)) {
            if ($niveau->getDomaineFormation() === $this) {
                $niveau->setDomaineFormation(null);
            }
        }

        return $this;
    }
}
