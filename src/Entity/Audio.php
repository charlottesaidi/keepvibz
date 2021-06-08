<?php

namespace App\Entity;

use App\Repository\AudioRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AudioRepository::class)
 */
class Audio
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Ce champ doit comporter {{ limit }} caractères au minimum",
     *      maxMessage = "Ce champ doit comporter {{ limit }} caractères au maximum"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="json")
     */
    private $type = [];

    /**
     * @Assert\NotBlank
     * @Assert\File(
     *    maxSize = "10000k",
     *    mimeTypes = {"application/mp3", "application/wma", "application/flac", "application/flac"},
     *    mimeTypesMessage = "Type de fichier non valide"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $file;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Ce champ doit comporter {{ limit }} caractères au minimum",
     *      maxMessage = "Ce champ doit comporter {{ limit }} caractères au maximum"
     * )
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleted_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="audios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this -> created_at = new \DateTime();
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): array
    {
        return $this->type;
    }

    public function setType(array $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modified_at;
    }

    public function setModifiedAt(?\DateTimeInterface $modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
