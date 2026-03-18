<?php

namespace App\Entity;

use App\Repository\EcoleAccreditationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EcoleAccreditationRepository::class)]
class EcoleAccreditation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateObtention = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateExpi = null;

    #[ORM\ManyToOne(targetEntity: Accreditation::class, inversedBy: 'ecoleAccreditations')]
    private ?Accreditation $accreditation = null;

    #[ORM\ManyToOne(targetEntity: Ecole::class, inversedBy: 'accreditations')]
    private ?Ecole $ecole = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateObtention(): ?\DateTimeInterface
    {
        return $this->dateObtention;
    }

    public function setDateObtention(?\DateTimeInterface $dateObtention): static
    {
        $this->dateObtention = $dateObtention;

        return $this;
    }

    public function getDateExpi(): ?\DateTimeInterface
    {
        return $this->dateExpi;
    }

    public function setDateExpi(?\DateTimeInterface $dateExpi): static
    {
        $this->dateExpi = $dateExpi;

        return $this;
    }

    public function getAccreditation(): ?Accreditation
    {
        return $this->accreditation;
    }

    public function setAccreditation(?Accreditation $accreditation): static
    {
        $this->accreditation = $accreditation;

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
}
