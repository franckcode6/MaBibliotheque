<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"book:read"}},
 *     denormalizationContext={"groups"={"book:write"}}
 * )
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     * @Groups({"book:write"})
     * @Groups({"book:read"})
     * @Groups({"author:read"})
     */
    private $title;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     * @Groups({"book:write"})
     * @Groups({"book:read"})
     */
    private $publishingDate;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     * @Groups({"book:write"})
     * @Groups({"book:read"})
     */
    private $publisher;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"book:write"})
     * @Groups({"book:read"})
     */
    private $author;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"book:write"})
     * @Groups({"book:read"})
     */
    private $ISBN;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     * @Groups({"book:write"})
     * @Groups({"book:read"})
     */
    private $genre;


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

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getISBN(): ?int
    {
        return $this->ISBN;
    }

    public function setISBN(?int $ISBN): self
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPublishingDate(): ?int
    {
        return $this->publishingDate;
    }

    public function setPublishingDate(int $publishingDate): self
    {
        $this->publishingDate = $publishingDate;

        return $this;
    }
}
