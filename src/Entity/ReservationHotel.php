<?php

namespace App\Entity;

use App\Repository\ReservationHotelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationHotelRepository::class)
 */
class ReservationHotel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=OffreHotel::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $offreHotel;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservationHotels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isValid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPurchased;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffreHotel(): ?OffreHotel
    {
        return $this->offreHotel;
    }

    public function setOffreHotel(?OffreHotel $offreHotel): self
    {
        $this->offreHotel = $offreHotel;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getIsPurchased(): ?bool
    {
        return $this->isPurchased;
    }

    public function setIsPurchased(bool $isPurchased): self
    {
        $this->isPurchased = $isPurchased;

        return $this;
    }
}
