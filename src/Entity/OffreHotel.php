<?php

namespace App\Entity;

use App\Repository\OffreHotelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreHotelRepository::class)
 */
class OffreHotel
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
    private $codePays;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPerson;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbRooms;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePays(): ?string
    {
        return $this->codePays;
    }

    public function setCodePays(string $codePays): self
    {
        $this->codePays = $codePays;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getNbPerson(): ?int
    {
        return $this->nbPerson;
    }

    public function setNbPerson(int $nbPerson): self
    {
        $this->nbPerson = $nbPerson;

        return $this;
    }

    public function getNbRooms(): ?int
    {
        return $this->nbRooms;
    }

    public function setNbRooms(int $nbRooms): self
    {
        $this->nbRooms = $nbRooms;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }
}
