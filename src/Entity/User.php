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
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="Un utilisateur existe déjà avec cette adresse e-mail")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
    * @SecurityAssert\UserPassword(
    *     message = "Ancien mot de passe invalide",
    *     groups={"profile-changePass"}
    * )
    */
   private $oldPassword;

    /**
     * @var string The hashed password
     * 
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "Ce champ doit comporter {{ limit }} caractères au minimum",
     * )
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/^\w+/")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Ce champ doit comporter {{ limit }} caractères au minimum",
     *      maxMessage = "Ce champ doit comporter {{ limit }} caractères au maximum"
     * )
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @Assert\Regex("/^\w+/")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Ce champ doit comporter {{ limit }} caractères au minimum",
     *      maxMessage = "Ce champ doit comporter {{ limit }} caractères au maximum"
     * )
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;

    /**
     * @Assert\Regex("/^\w+/")
     * @ORM\Column(type="string", nullable=true)
     */
    private $town;

    /**
     * @AssertPhoneNumber
     * @ORM\Column(type="phone_number", nullable=true)
     */
    private $phoneNumber;

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
     * @ORM\OneToOne(targetEntity=Avatar::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Texte::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $textes;

    /**
     * @ORM\OneToMany(targetEntity=Topline::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $toplines;

    /**
     * @ORM\OneToMany(targetEntity=Instru::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $instrus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reset_token;

    public function __construct()
    {
        $this -> created_at = new \DateTime();
        $this->competences = new ArrayCollection();
        $this->textes = new ArrayCollection();
        $this->toplines = new ArrayCollection();
        $this->instrus = new ArrayCollection();
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

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

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

    function getOldPassword() {
        return $this->oldPassword;
    }

    function setOldPassword($oldPassword) {
        $this->oldPassword = $oldPassword;
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

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

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
            $topline->setUser($this);
        }

        return $this;
    }

    public function removeTopline(Topline $topline): self
    {
        if ($this->toplines->removeElement($topline)) {
            // set the owning side to null (unless already changed)
            if ($topline->getUser() === $this) {
                $topline->setUser(null);
            }
        }

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
            $instru->setUser($this);
        }

        return $this;
    }

    public function removeInstru(Instru $instru): self
    {
        if ($this->instrus->removeElement($instru)) {
            // set the owning side to null (unless already changed)
            if ($instru->getUser() === $this) {
                $instru->setUser(null);
            }
        }

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;

        return $this;
    }
}
