<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
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
     * @Assert\Length(min=6, minMessage="Votre mot de passe doit contenir au moins 6 caractères")
     * @Assert\EqualTo(propertyPath="confirm_password", message="Vos mot de passe sont différents")
     */
    private $password;

    /**
     * @var string
     * @Assert\EqualTo(propertyPath="password", message="Vos mot de passe sont différents")
     */
    private $confirmPassword;

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

    public function __construct()
    {
        $this->favoritesCourses = new ArrayCollection();
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
        return (string) $this->email;
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
        return (string) $this->password;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }


    /**
     * Get the value of confirmPassword
     *
     * @return  string
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * Set the value of confirmPassword
     *
     * @param  string  $confirmPassword
     *
     * @return  self
     */
    public function setConfirmPassword(string $confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;

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
}
