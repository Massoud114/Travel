<?php

namespace App\Entity;

use App\Repository\ReservationVolRepository;
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
     * @ORM\ManyToOne(targetEntity=OffreVol::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private OffreVol $offre;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $documentType;

    /**
     * @ORM\OneToOne(targetEntity=Billet::class, mappedBy="vol", cascade={"persist", "remove"})
     */
    private $billet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffre(): ?OffreVol
    {
        return $this->offre;
    }

    public function setOffre(?OffreVol $offre): self
    {
        $this->offre = $offre;

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

    public function getDocumentType(): ?string
    {
        return $this->documentType;
    }

    public function setDocumentType(?string $documentType): self
    {
        $this->documentType = $documentType;

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
}
