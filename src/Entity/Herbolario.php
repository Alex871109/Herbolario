<?php

namespace App\Entity;
use App\Repository\HerbolarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Herbolario
 *
 * @ORM\Table(name="herbolario")
 * @ORM\Entity(repositoryClass= HerbolarioRepository::class)
 */
class Herbolario
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="URL", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Planta", mappedBy="herbolarioid")
     */
    private $plantaid = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->plantaid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, Planta>
     */
    public function getPlantaid(): Collection
    {
        return $this->plantaid;
    }

    public function addPlantaid(Planta $plantaid): self
    {
        if (!$this->plantaid->contains($plantaid)) {
            $this->plantaid->add($plantaid);
            $plantaid->addHerbolarioid($this);
        }

        return $this;
    }

    public function removePlantaid(Planta $plantaid): self
    {
        if ($this->plantaid->removeElement($plantaid)) {
            $plantaid->removeHerbolarioid($this);
        }

        return $this;
    }

}
