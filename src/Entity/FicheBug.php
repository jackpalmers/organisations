<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FicheBugRepository")
 */
class FicheBug
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
    private $ProjectName;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Note;

    /**
     * @ORM\Column(type="integer")
     */
    private $Etat;

    /**
     * @ORM\Column(type="integer")
     */
    private $numFiche;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectName(): ?string
    {
        return $this->ProjectName;
    }

    public function setProjectName(string $ProjectName): self
    {
        $this->ProjectName = $ProjectName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->Note;
    }

    public function setNote(?string $Note): self
    {
        $this->Note = $Note;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->Etat;
    }

    public function setEtat(int $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }

    public function getNumFiche(): ?int
    {
        return $this->numFiche;
    }

    public function setNumFiche(int $numFiche): self
    {
        $this->numFiche = $numFiche;

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
