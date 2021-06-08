<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="Un compte existe déjà avec cette adresse e-mail")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "Adresse e-mail invalide"
     * )
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "Ce champ doit comporter {{ limit }} caractères au minimum",
     * )
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Ce champ doit comporter {{ limit }} caractères au minimum",
     *      maxMessage = "Ce champ doit comporter {{ limit }} caractères au maximum"
     * )
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    // /**
    //  * @Assert\Length(
    //  *      min = 2,
    //  *      max = 255,
    //  *      minMessage = "Ce champ doit comporter {{ limit }} caractères au minimum",
    //  *      maxMessage = "Ce champ doit comporter {{ limit }} caractères au maximum"
    //  * )
    //  * @ORM\Column(type="text", nullable=true)
    //  */
    // private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $town;

    /**
     * @Assert\Length(
     *      min = 10,
     *      max = 10,
     *      minMessage = "Renseignez un numéro de téléphone valide",
     *      maxMessage = "Renseignez un numéro de téléphone valide"
     * )
     * @Assert\Regex(pattern="/^([123]0|[012][1-9]|31)\/(0[1-9]|1[012])\/(19[0-9]{2}|2[0-9]{3})$/", message="Renseignez un numéro de téléphone valide")
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified_at;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="users")
     */
    private $competences;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="user")
     */
    private $annonces;

    /**
     * @ORM\OneToOne(targetEntity=Avatar::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Audio::class, mappedBy="user")
     */
    private $audios;

    /**
     * @ORM\OneToMany(targetEntity=Texte::class, mappedBy="user")
     */
    private $textes;

    public function __construct()
    {
        $this -> created_at = new \DateTime();
        $this->competences = new ArrayCollection();
        $this->annonces = new ArrayCollection();
        $this->audios = new ArrayCollection();
        $this->textes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserName(): string
    {
        return (string) $this->email;
    }

    // public function getDescription(): ?string
    // {
    //     return $this->description;
    // }

    // public function setDescription(string $description): self
    // {
    //     $this->description = $description;

    //     return $this;
    // }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

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

    /**
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        $this->competences->removeElement($competence);

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setUser($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getUser() === $this) {
                $annonce->setUser(null);
            }
        }

        return $this;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(?Avatar $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Audio[]
     */
    public function getAudios(): Collection
    {
        return $this->audios;
    }

    public function addAudio(Audio $audio): self
    {
        if (!$this->audios->contains($audio)) {
            $this->audios[] = $audio;
            $audio->setUser($this);
        }

        return $this;
    }

    public function removeAudio(Audio $audio): self
    {
        if ($this->audios->removeElement($audio)) {
            // set the owning side to null (unless already changed)
            if ($audio->getUser() === $this) {
                $audio->setUser(null);
            }
        }

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
            $texte->setUser($this);
        }

        return $this;
    }

    public function removeTexte(Texte $texte): self
    {
        if ($this->textes->removeElement($texte)) {
            // set the owning side to null (unless already changed)
            if ($texte->getUser() === $this) {
                $texte->setUser(null);
            }
        }

        return $this;
    }
}
