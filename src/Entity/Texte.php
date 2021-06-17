<?php

namespace App\Entity;

use App\Repository\TexteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=TexteRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Texte
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
     * @ORM\Column(type="string")
     */
    private $status;

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
     * @Assert\Regex("/^\w+/")
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Ce champ doit comporter {{ limit }} caractères au minimum",
     * )
     * @ORM\Column(type="string")
     */
    private $couplet;

    /**
     * @Assert\Regex("/^\w+/")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Ce champ doit comporter {{ limit }} caractères au minimum",
     * )
     * @ORM\Column(type="text")
     */
    private $refrain;
    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="textes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Instru::class, inversedBy="textes")
     */
    private $instrus;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->instrus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
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

    public function getCouplet(): string
    {
        $couplet = $this->couplet;
        return $this->couplet;
    }

    public function setCouplet(string $couplet): self
    {
        $this->couplet = $couplet;

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

    public function getRefrain(): ?string
    {
        return $this->refrain;
    }

    public function setRefrain(string $refrain): self
    {
        $this->refrain = $refrain;

        return $this;
    }

    /**
     * @return Collection|Instru[]
     */
    public function getInstrus(): Collection
    {
        return $this->instrus;
    }

    public function addInstru(Instru $instru): self
    {
        if (!$this->instrus->contains($instru)) {
            $this->instrus[] = $instru;
        }

        return $this;
    }

    public function removeInstru(Instru $instru): self
    {
        $this->instrus->removeElement($instru);

        return $this;
    }
}
