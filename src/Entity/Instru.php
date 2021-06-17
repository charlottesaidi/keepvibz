<?php

namespace App\Entity;

use App\Repository\InstruRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=InstruRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Instru
{
    /**
     * Hook SoftDeleteable behavior
     * updates deletedAt field
     */
    use SoftDeleteableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/^\w+/")
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
     * @Assert\Range(
     *      min = 70,
     *      max = 180,
     *      notInRangeMessage = "Cette valeur doit être un nombre entre {{ min }} et {{ max }}",
     * )
     * @ORM\Column(type="integer")
     */
    private $bpm;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/^\w+/")
     * @ORM\Column(type="string", length=255)
     */
    private $cle;

    /**
     * @Assert\NotBlank
     * @Assert\File(
     *    maxSize = "10000k",
     *    mimeTypes = {"audio/mpeg", "audio/wma", "audio/flac"},
     *    mimeTypesMessage = "Format de fichier invalide"
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="instrus")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Texte::class, mappedBy="instrus", cascade={"persist", "remove"})
     */
    private $textes;

    /**
     * @ORM\OneToMany(targetEntity=Topline::class, mappedBy="instru", cascade={"persist", "remove"})
     */
    private $toplines;

    public function __construct()
    {
        $this -> created_at = new \DateTime();
        $this->textes = new ArrayCollection();
        $this->toplines = new ArrayCollection();
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

    public function setFile(?string $file): self
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $texte->addInstru($this);
        }

        return $this;
    }

    public function removeTexte(Texte $texte): self
    {
        if ($this->textes->removeElement($texte)) {
            $texte->removeInstru($this);
        }

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
            $topline->setInstru($this);
        }

        return $this;
    }

    public function removeTopline(Topline $topline): self
    {
        if ($this->toplines->removeElement($topline)) {
            // set the owning side to null (unless already changed)
            if ($topline->getInstru() === $this) {
                $topline->setInstru(null);
            }
        }

        return $this;
    }

    public function getInfos() {
        return $data = [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'genre' => $this->getGenre(),
            'bpm' => $this->getBpm(),
            'cle' => $this->getCle(),
            'file' => $this->getFile(),
            'image' => $this->getImage(),
            'created_at' => $this->getCreatedAt(),
            'modified_at' => $this->getModifiedAt(),
            'user' => $this->getUser(),
            'textes' => $this->getTextes(),
            'toplines' => $this->getToplines(),            
        ];
    }
}
