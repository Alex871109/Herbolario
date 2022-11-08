<?php

namespace App\Entity;
use Stringable;
use App\Repository\HerbolarioRepository;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Herbolario
 */
#[ORM\Table(name: 'herbolario')]
#[ORM\Entity(repositoryClass: HerbolarioRepository::class)]
class Herbolario implements Stringable
{
    #[ORM\Column(name: 'ID', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[Groups('basic')]
    private ?int $id = null;

    #[ORM\Column(name: 'Nombre', type: 'string', length: 100, nullable: true)]
    #[Groups('basic')]
    private ?string $nombre = null;

    #[ORM\Column(name: 'URL', type: 'string', length: 255, nullable: true)]
    #[Groups('basic')]
    private ?string $url = null;

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

    public function __toString(): string
    {

        return (string) $this->nombre;
    }


}
