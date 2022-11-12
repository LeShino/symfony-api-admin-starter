<?php

namespace App\Entity;

use App\Repository\ReversementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReversementRepository::class)
 */
class Reversement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reversant;

    /**
     * @ORM\Column(type="float")
     */
    private $montantReverse;

    /**
     * @ORM\Column(type="string", length=191)
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateReversement;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reversements")
     */
    private $marchand;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $creeLe;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifieLe;

    public function __construct()
    {
        $this->creeLe =  new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReversant(): ?string
    {
        return $this->reversant;
    }

    public function setReversant(string $reversant): self
    {
        $this->reversant = $reversant;

        return $this;
    }

    public function getMontantReverse(): ?float
    {
        return $this->montantReverse;
    }

    public function setMontantReverse(float $montantReverse): self
    {
        $this->montantReverse = $montantReverse;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateReversement(): ?\DateTimeInterface
    {
        return $this->dateReversement;
    }

    public function setDateReversement(\DateTimeInterface $dateReversement): self
    {
        $this->dateReversement = $dateReversement;

        return $this;
    }

    public function getMarchand(): ?User
    {
        return $this->marchand;
    }

    public function setMarchand(?User $marchand): self
    {
        $this->marchand = $marchand;

        return $this;
    }

    public function getCreeLe(): ?\DateTimeInterface
    {
        return $this->creeLe;
    }

    public function setCreeLe(?\DateTimeInterface $creeLe): self
    {
        $this->creeLe = $creeLe;

        return $this;
    }

    public function getModifieLe(): ?\DateTimeInterface
    {
        return $this->modifieLe;
    }

    public function setModifieLe(?\DateTimeInterface $modifieLe): self
    {
        $this->modifieLe = $modifieLe;

        return $this;
    }
}
