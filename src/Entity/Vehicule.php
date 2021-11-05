<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VehiculeRepository::class)
 */
class Vehicule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $designation;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\Range(min=2, max=8, notInRangeMessage="Le nombre de places doit être compris entre {{ min }}  et {{ max }}")
     */
    private $placeVoiture;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateAchat;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="vehicule")
     */
    private $reservations;

    /**
     * @ORM\ManyToOne(targetEntity=TypeVehicule::class, inversedBy="vehicules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=EtatVehicule::class, inversedBy="vehicules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="vehicules")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agence;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $photo;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->dateAchat;
    }

    public function setDateAchat(?\DateTimeInterface $dateAchat): self
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setVehicule($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getVehicule() === $this) {
                $reservation->setVehicule(null);
            }
        }

        return $this;
    }

    public function getType(): ?TypeVehicule
    {
        return $this->type;
    }

    public function setType(?TypeVehicule $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEtat(): ?EtatVehicule
    {
        return $this->etat;
    }

    public function setEtat(?EtatVehicule $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    public function getPlaceVoiture(): ?int
    {
        return $this->placeVoiture;
    }

    public function setPlaceVoiture(int $placeVoiture): self
    {
        $this->placeVoiture = $placeVoiture;

        return $this;
    }
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
