<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 */
class Course implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CourseCategory", inversedBy="courses")
     */
    private $courseCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CourseFavorites", mappedBy="course", cascade={"remove"})
     */
    private $courseFavorites;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\LabelCourse", inversedBy="courses")
     */
    private $labels;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CourseDocument", mappedBy="course")
     */
    private $documents;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    public function __construct()
    {
        $this->courseFavorites = new ArrayCollection();
        $this->labels = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCourseCategory(): ?CourseCategory
    {
        return $this->courseCategory;
    }

    public function setCourseCategory(?CourseCategory $courseCategory): self
    {
        $this->courseCategory = $courseCategory;

        return $this;
    }

    /**
     * @return Collection|CourseFavorites[]
     */
    public function getCourseFavorites(): Collection
    {
        return $this->courseFavorites;
    }

    public function addCourseFavorite(CourseFavorites $courseFavorite): self
    {
        if (!$this->courseFavorites->contains($courseFavorite)) {
            $this->courseFavorites[] = $courseFavorite;
            $courseFavorite->setCourse($this);
        }

        return $this;
    }

    public function removeCourseFavorite(CourseFavorites $courseFavorite): self
    {
        if ($this->courseFavorites->contains($courseFavorite)) {
            $this->courseFavorites->removeElement($courseFavorite);
            // set the owning side to null (unless already changed)
            if ($courseFavorite->getCourse() === $this) {
                $courseFavorite->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * is a Course liked by a user
     */
    public function isLikedByUser(User $user)
    {
        foreach ($this->courseFavorites as $favorite) {
            if ($favorite->getUser() === $user) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Collection|LabelCourse[]
     */
    public function getLabels(): Collection
    {
        return $this->labels;
    }

    public function addLabel(LabelCourse $label): self
    {
        if (!$this->labels->contains($label)) {
            $this->labels[] = $label;
        }

        return $this;
    }

    public function removeLabel(LabelCourse $label): self
    {
        if ($this->labels->contains($label)) {
            $this->labels->removeElement($label);
        }

        return $this;
    }

    /**
     * needed for easy_admin in form rendering
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|CourseDocument[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(CourseDocument $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setCourse($this);
        }

        return $this;
    }

    public function removeDocument(CourseDocument $document): self
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            // set the owning side to null (unless already changed)
            if ($document->getCourse() === $this) {
                $document->setCourse(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function jsonSerialize()
    {
        $arrayLabels = [];
        foreach($this->labels as $label){
            $arrayLabels[] = $label->getName();
        }
        $arrayFiles = [];
        foreach($this->documents as $document){
            $arrayFiles[] = [
                "name" => $document->getName(),
                "author" => $document->getAuthor()->getEmail(),
                "label" => $document->getLabel()->getName(),
                "date" => $document->getUpdatedAt()];
        }

        return array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->courseCategory->getName(),
            'semester' => $this->courseCategory->getSemester(),
            'promotion' => $this->courseCategory->getPromotion(),
            'labels' => $arrayLabels,
            'documents' => array_reverse($arrayFiles),
        );
    }
}
