<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use App\Repository\AlbumRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlbumRepository::class)
 * @ApiResource(normalizationContext={"groups"={"outAlbum"}},
 *  collectionOperations={
 *      "get",
 *      "post"={"security"="is_granted('ROLE_USER')"}
 *  }
 * )
 */
#[ApiResource]
class Album
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"outAlbum"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"outAlbum"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"outAlbum"})
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity=Artist::class, inversedBy="album", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"outAlbum"})
     */
    private $artist;

    /**
     * @ORM\OneToOne(targetEntity=Song::class, mappedBy="album", cascade={"persist", "remove"})
     */
    private $song;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getSong(): ?Song
    {
        return $this->song;
    }

    public function setSong(Song $song): self
    {
        // set the owning side of the relation if necessary
        if ($song->getAlbum() !== $this) {
            $song->setAlbum($this);
        }

        $this->song = $song;

        return $this;
    }
}
