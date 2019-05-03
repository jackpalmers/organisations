<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TacheSportRepository")
 */
class TacheSport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomSport;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $Duree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Nombre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateSeance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSport(): ?string
    {
        return $this->NomSport;
    }

    public function setNomSport(string $NomSport): self
    {
        $this->NomSport = $NomSport;

        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->Duree;
    }

    public function setDuree(?\DateTimeInterface $Duree): self
    {
        $this->Duree = $Duree;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(?string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getDateSeance(): ?\DateTimeInterface
    {
        return $this->DateSeance;
    }

    public function setDateSeance(\DateTimeInterface $DateSeance): self
    {
        $this->DateSeance = $DateSeance;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
