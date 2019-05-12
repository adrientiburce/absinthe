<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email",
 *      message="Cette adresse email a déjà été renseignée")
 * @UniqueEntity("pseudo")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\Email(
     *     message = "L'email {{ value }} n'es pas valide")
     * @Assert\Regex(
     *      pattern="/@centrale.centralelille.fr$/",
     *      message="Votre adresse doit avoir comme domaine : @centrale.centralelille.fr"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=100, unique=true, nullable=true)
     * @Assert\Length(min=4, minMessage="Votre pseudo doit contenir au moins 4 caractères")
     */
    private $pseudo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CourseFavorites", mappedBy="user")
     */
    private $favoritesCourses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CourseDocument", mappedBy="author")
     */
    private $courseDocuments;

    public function __construct()
    {
        $this->favoritesCourses = new ArrayCollection();
        $this->courseDocuments = new ArrayCollection();
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
    public function getUsername(): string
    {
        return (string)$this->email;
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

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }


    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return Collection|CourseFavorites[]
     */
    public function getFavoritesCourses(): Collection
    {
        return $this->favoritesCourses;
    }

    public function addFavoritesCourse(CourseFavorites $favoritesCourse): self
    {
        if (!$this->favoritesCourses->contains($favoritesCourse)) {
            $this->favoritesCourses[] = $favoritesCourse;
            $favoritesCourse->setUser($this);
        }

        return $this;
    }

    public function removeFavoritesCourse(CourseFavorites $favoritesCourse): self
    {
        if ($this->favoritesCourses->contains($favoritesCourse)) {
            $this->favoritesCourses->removeElement($favoritesCourse);
            // set the owning side to null (unless already changed)
            if ($favoritesCourse->getUser() === $this) {
                $favoritesCourse->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CourseDocument[]
     */
    public function getCourseDocuments(): Collection
    {
        return $this->courseDocuments;
    }

    public function addCourseDocument(CourseDocument $courseDocument): self
    {
        if (!$this->courseDocuments->contains($courseDocument)) {
            $this->courseDocuments[] = $courseDocument;
            $courseDocument->setAuthor($this);
        }

        return $this;
    }

    public function removeCourseDocument(CourseDocument $courseDocument): self
    {
        if ($this->courseDocuments->contains($courseDocument)) {
            $this->courseDocuments->removeElement($courseDocument);
            // set the owning side to null (unless already changed)
            if ($courseDocument->getAuthor() === $this) {
                $courseDocument->setAuthor(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->email;
    }
}
