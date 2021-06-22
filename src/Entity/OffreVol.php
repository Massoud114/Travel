<?php

namespace App\Entity;

use App\Repository\OffreVolRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreVolRepository::class)
 */
class OffreVol
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
    private $source;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOneWay;

    /**
     * @ORM\ManyToOne(targetEntity=Voyage::class, inversedBy="offreVols")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voyage;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $volType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $company;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getIsOneWay(): ?bool
    {
        return $this->isOneWay;
    }

    public function setIsOneWay(bool $isOneWay): self
    {
        $this->isOneWay = $isOneWay;

        return $this;
    }

    public function getVoyage(): ?Voyage
    {
        return $this->voyage;
    }

    public function setVoyage(?Voyage $voyage): self
    {
        $this->voyage = $voyage;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVolType(): ?int
    {
        return $this->volType;
    }

    public function setVolType(int $volType): self
    {
        $this->volType = $volType;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
