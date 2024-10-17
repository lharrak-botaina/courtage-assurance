<?php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VoitureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
#[ApiResource]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_immatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $vehicleUsage = null;

    #[ORM\Column(length: 255)]
    private ?string $emplacement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_achat = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    private ?Client $client = null;

    /**
     * @var Collection<int, Devis>
     */
    #[ORM\ManyToMany(targetEntity: Devis::class, mappedBy: 'voitures', cascade: ['persist'])]
    private Collection $devis;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroImmatriculation(): ?string
    {
        return $this->numero_immatriculation;
    }

    public function setNumeroImmatriculation(string $numero_immatriculation): static
    {
        $this->numero_immatriculation = $numero_immatriculation;

        return $this;
    }

    public function getVehicleUsage(): ?string
    {
        return $this->vehicleUsage;
    }

    public function setVehicleUsage(string $vehicleUsage): static
    {
        $this->vehicleUsage = $vehicleUsage;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): static
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->date_achat;
    }

    public function setDateAchat(\DateTimeInterface $date_achat): static
    {
        $this->date_achat = $date_achat;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Devis>
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevis(Devis $devis): static
    {
        if (!$this->devis->contains($devis)) {
            $this->devis->add($devis);
        }

        return $this;
    }

    public function removeDevis(Devis $devis): static
    {
        $this->devis->removeElement($devis);
        return $this;
    }
}
