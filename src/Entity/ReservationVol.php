<?php

namespace App\Entity;

use App\Repository\ReservationVolRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationVolRepository::class)
 */
class ReservationVol
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;
    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isValid;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isPurchased;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $origin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $destination;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $departureDate;

    /**
     * @ORM\OneToOne(targetEntity=Billet::class, mappedBy="vol", cascade={"persist", "remove"})
     */
    private $billet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
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

    public function getBillet(): ?Billet
    {
        return $this->billet;
    }

    public function setBillet(Billet $billet): self
    {
        // set the owning side of the relation if necessary
        if ($billet->getVol() !== $this) {
            $billet->setVol($this);
        }

        $this->billet = $billet;

        return $this;
    }

	/**
	 * @return string
	 */
	public function getOrigin(): string
	{
		return $this->origin;
	}

	/**
	 * @param string $origin
	 * @return ReservationVol
	 */
	public function setOrigin(string $origin): ReservationVol
	{
		$this->origin = $origin;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDestination(): string
	{
		return $this->destination;
	}

	/**
	 * @param string $destination
	 * @return ReservationVol
	 */
	public function setDestination(string $destination): ReservationVol
	{
		$this->destination = $destination;
		return $this;
	}

	/**
	 * @return String
	 */
	public function getDepartureDate(): String
	{
		return $this->departureDate;
	}

	/**
	 * @param string $departureDate
	 * @return ReservationVol
	 */
	public function setDepartureDate(String $departureDate): ReservationVol
	{
		$this->departureDate = $departureDate;
		return $this;
	}


}
