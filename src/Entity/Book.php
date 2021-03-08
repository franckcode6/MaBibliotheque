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
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Groups({"book:write"})
     * @Groups({"book:read"})
     */
    private $year;

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

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

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
}
