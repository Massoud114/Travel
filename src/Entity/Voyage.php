<?php

namespace App\Entity;

use App\Repository\VoyageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoyageRepository::class)
 */
class Voyage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateVoyage;

    /**
     * @ORM\OneToMany(targetEntity=OffreVol::class, mappedBy="voyage", orphanRemoval=true)
     */
    private $offreVols;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $codePaysDepart;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $codePaysDestination;

    public function __construct()
    {
        $this->offreVols = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVoyage(): ?\DateTimeInterface
    {
        return $this->dateVoyage;
    }

    public function setDateVoyage(\DateTimeInterface $dateVoyage): self
    {
        $this->dateVoyage = $dateVoyage;

        return $this;
    }

    /**
     * @return Collection|OffreVol[]
     */
    public function getOffreVols(): Collection
    {
        return $this->offreVols;
    }

    public function addOffreVol(OffreVol $offreVol): self
    {
        if (!$this->offreVols->contains($offreVol)) {
            $this->offreVols[] = $offreVol;
            $offreVol->setVoyage($this);
        }

        return $this;
    }

    public function removeOffreVol(OffreVol $offreVol): self
    {
        if ($this->offreVols->removeElement($offreVol)) {
            // set the owning side to null (unless already changed)
            if ($offreVol->getVoyage() === $this) {
                $offreVol->setVoyage(null);
            }
        }

        return $this;
    }

    public function getCodePaysDepart(): ?Country
    {
        return $this->codePaysDepart;
    }

    public function setCodePaysDepart(?Country $codePaysDepart): self
    {
        $this->codePaysDepart = $codePaysDepart;

        return $this;
    }

    public function getCodePaysDestination(): ?Country
    {
        return $this->codePaysDestination;
    }

    public function setCodePaysDestination(?Country $codePaysDestination): self
    {
        $this->codePaysDestination = $codePaysDestination;

        return $this;
    }
}
