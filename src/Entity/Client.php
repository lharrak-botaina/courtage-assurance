<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column]
    private ?bool $est_personne = null;

    /**
     * @var Collection<int, Devis>
     */
    #[ORM\OneToMany(targetEntity: Devis::class, mappedBy: 'client', cascade: ['persist'])] 
    private Collection $devis;

    /**
     * @var Collection<int, voiture>
     */
    #[ORM\OneToMany(targetEntity: Voiture::class, mappedBy: 'client', cascade: ['persist'])] 
    private Collection $voitures;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
        $this->voitures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): static
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function isEstPersonne(): ?bool
    {
        return $this->est_personne;
    }

    public function setEstPersonne(bool $est_personne): static
    {
        $this->est_personne = $est_personne;

        return $this;
    }

    /**
     * @return Collection<int, Devis>
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): static
    {
        if (!$this->devis->contains($devi)) {
            $this->devis->add($devi);
            $devi->setClient($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): static
    {
        if ($this->devis->removeElement($devi)) {
           
            if ($devi->getClient() === $this) {
                $devi->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, voiture>
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }

    public function addVoiture(voiture $voiture): static
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures->add($voiture);
            $voiture->setClient($this);
        }

        return $this;
    }

    public function removeVoiture(voiture $voiture): static
    {
        if ($this->voitures->removeElement($voiture)) {
            
            if ($voiture->getClient() === $this) {
                $voiture->setClient(null);
            }
        }

        return $this;
    }
}
