<?php

namespace App\Entity;
use Stringable;
use App\Repository\PlantaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Planta
 */
#[ORM\Table(name: 'planta')]
#[ORM\Entity(repositoryClass: PlantaRepository::class)]
class Planta implements Stringable
{
    #[ORM\Column(name: 'Especie', type: 'string', length: 100, nullable: true)]
    #[Groups('form_planta')]
    private ?string $especie = null;

    #[ORM\Column(name: 'ID', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[Groups('form_planta')]
    private ?int $id = null;

    #[ORM\Column(name: 'Nombre', type: 'string', length: 100, nullable: false)]
    #[Groups(['form_planta', 'basic'])]
    private ?string $nombre = null;

    #[ORM\Column(name: 'Lugar', type: 'string', length: 255, nullable: true)]
    #[Groups('form_planta')]
    private ?string $lugar = null;

    #[ORM\JoinTable(name: 'plantasusos')]
    #[ORM\JoinColumn(name: 'Planta', referencedColumnName: 'ID')]
    #[ORM\InverseJoinColumn(name: 'Uso', referencedColumnName: 'ID')]
    #[ORM\ManyToMany(targetEntity: 'Usos', inversedBy: 'planta')]
    #[Groups('form_planta')]
    private Collection $uso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->uso = new ArrayCollection();
    }

    public function getEspecie(): ?string
    {
        return $this->especie;
    }

    public function setEspecie(?string $especie): self
    {
        $this->especie = $especie;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getLugar(): ?string
    {
        return $this->lugar;
    }

    public function setLugar(?string $lugar): self
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * @return Collection<int, Usos>
     */
    public function getUso(): Collection
    {
        return $this->uso;
    }

    public function addUso(Usos $uso): self
    {
        if (!$this->uso->contains($uso)) {
            $this->uso->add($uso);
        }

        return $this;
    }

    public function removeUso(Usos $uso): self
    {
        if($this->uso->contains($uso))
            $this->uso->removeElement($uso);

        return $this;
    }

    public function __toString(): string
    {

        return $this->nombre;
    }





}
