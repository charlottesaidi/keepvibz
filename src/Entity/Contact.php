<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity; 
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity (repositoryClass=ContactRepository::class)
 * @Gedmo\SoftDeleteable (fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Contact
{
    /**
     *Hook SoftDeleteable behavior
     *updates deletedAt field
     */
    use SoftDeleteableEntity ;

    /**
     *@ORM\Id
     *@ORM\GeneratedValue
     *@ORM\Column(type="integer")
     */
    private $id ;

    /**
     *@Assert\NotBlank
     *@ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     *@Assert\NotBlank
     *@Assert\Email(
     *    message = "Renseignez une adresse e-mail valide"
     * )
     *@ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Subject;

    /**
     *@Assert\NotBlank
     *@ORM\Column(type="text")
     */
    private $Message;

    /**
     *@ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     *@ORM\Column(type="boolean")
     */
    private $unread =true;

   public function __construct()
    {
      $this->created_at = new \DateTime();
    }

   public function getId(): ?int
    {
       return $this->id;
    }

   public function getName(): ?string
    {
       return $this->Name;
    }

   public function setName(string $Name): self
    {
       $this->Name = $Name;

       return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->Subject;
    }

    public function setSubject(?string $Subject): self
    {
        $this->Subject = $Subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(string $Message): self
    {
        $this->Message = $Message;

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

   public function getUnread(): ?bool
    {
       return $this->unread;
    }

   public function setUnread(bool $unread): self
    {
       $this->unread = $unread;

       return $this;
    }
}
