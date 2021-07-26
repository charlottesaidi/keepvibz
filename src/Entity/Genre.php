<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=GenreRepository::class)
 */
class Genre
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
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToMany(targetEntity=Instru::class, mappedBy="genres")
     */
    private $instrus;

    public function __construct()
    {
        $this -> created_at = new \DateTime();
        $this->instrus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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
            $instru->addGenre($this);
        }

        return $this;
    }

    public function removeInstru(Instru $instru): self
    {
        if ($this->instrus->removeElement($instru)) {
            $instru->removeGenre($this);
        }

        return $this;
    }

    public function getInfos() {
        return $data = [
            'id' => $this->getId(),
            'label' => $this->getLabel(),
            'created_at' => $this->getCreatedAt(),            
        ];
    }
}
