<?php

namespace App\Entity;

use App\Repository\AccreditationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccreditationRepository::class)]
class Accreditation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $organisme = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $niveau = null;

    #[ORM\OneToMany(targetEntity: EcoleAccreditation::class, mappedBy: 'accreditation')]
    private Collection $ecoleAccreditations;

    public function __construct()
    {
        $this->ecoleAccreditations = new ArrayCollection();
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

    public function getOrganisme(): ?string
    {
        return $this->organisme;
    }

    public function setOrganisme(string $organisme): static
    {
        $this->organisme = $organisme;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection<int, EcoleAccreditation>
     */
    public function getEcoleAccreditations(): Collection
    {
        return $this->ecoleAccreditations;
    }

    public function addEcoleAccreditation(EcoleAccreditation $ecoleAccreditation): static
    {
        if (!$this->ecoleAccreditations->contains($ecoleAccreditation)) {
            $this->ecoleAccreditations->add($ecoleAccreditation);
            $ecoleAccreditation->setAccreditation($this);
        }

        return $this;
    }

    public function removeEcoleAccreditation(EcoleAccreditation $ecoleAccreditation): static
    {
        if ($this->ecoleAccreditations->removeElement($ecoleAccreditation)) {
            if ($ecoleAccreditation->getAccreditation() === $this) {
                $ecoleAccreditation->setAccreditation(null);
            }
        }

        return $this;
    }
}
