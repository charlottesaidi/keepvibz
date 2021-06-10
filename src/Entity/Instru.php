<?php

namespace App\Entity;

use App\Repository\InstruRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InstruRepository::class)
 */
class Instru
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
     * @Assert\Unique
     * @ORM\Column(type="json")
     */
    private $genre = [];

    /**
     * @Assert\NotBlank
     * @Assert\Positive
     * @ORM\Column(type="integer")
     */
    private $bpm;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $cle;

    /**
     * @Assert\NotBlank
     * @Assert\File(
     *    maxSize = "10000k",
     *    mimeTypes = {"application/mpeg-1", "application/wma", "application/flac"},
     *    mimeTypesMessage = "Format de fichier invalide"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

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
     * @ORM\ManyToMany(targetEntity=Topline::class, inversedBy="instrus")
     */
    private $toplines;

    /**
     * @ORM\OneToMany(targetEntity=Texte::class, mappedBy="instru")
     */
    private $textes;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="instrus")
     */
    private $user;

    public function __construct()
    {
        $this -> created_at = new \DateTime();
        $this->toplines = new ArrayCollection();
        $this->textes = new ArrayCollection();
    }

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

    public function getGenre(): ?array
    {
        return $this->genre;
    }

    public function setGenre(array $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getBpm(): ?int
    {
        return $this->bpm;
    }

    public function setBpm(int $bpm): self
    {
        $this->bpm = $bpm;

        return $this;
    }

    public function getCle(): ?string
    {
        return $this->cle;
    }

    public function setCle(string $cle): self
    {
        $this->cle = $cle;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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

    public function setDeletedAt(?\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @return Collection|Topline[]
     */
    public function getToplines(): Collection
    {
        return $this->toplines;
    }

    public function addTopline(Topline $topline): self
    {
        if (!$this->toplines->contains($topline)) {
            $this->toplines[] = $topline;
        }

        return $this;
    }

    public function removeTopline(Topline $topline): self
    {
        $this->toplines->removeElement($topline);

        return $this;
    }

    /**
     * @return Collection|Texte[]
     */
    public function getTextes(): Collection
    {
        return $this->textes;
    }

    public function addTexte(Texte $texte): self
    {
        if (!$this->textes->contains($texte)) {
            $this->textes[] = $texte;
            $texte->setInstru($this);
        }

        return $this;
    }

    public function removeTexte(Texte $texte): self
    {
        if ($this->textes->removeElement($texte)) {
            // set the owning side to null (unless already changed)
            if ($texte->getInstru() === $this) {
                $texte->setInstru(null);
            }
        }

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
