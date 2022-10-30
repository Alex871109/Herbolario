<?php

namespace App\Entity;
use App\Repository\HerbolarioRepository;

use Doctrine\ORM\Mapping as ORM;



/**
 * Herbolario
 *
 * @ORM\Table(name="herbolario")
 * @ORM\Entity(repositoryClass=HerbolarioRepository::Class)
 */
class Herbolario
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("basic")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nombre", type="string", length=100, nullable=true)
     * @Groups("basic")
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="URL", type="string", length=255, nullable=true)
     * @Groups("basic")
     */
    private $url;

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

    public function __toString()
    {

        return $this->nombre;
    }


}
