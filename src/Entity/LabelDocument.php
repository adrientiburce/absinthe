<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LabelDocumentRepository")
 */
class LabelDocument
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
     * @ORM\OneToMany(targetEntity="App\Entity\CourseDocument", mappedBy="label")
     */
    private $courseDocuments;

    public function __construct()
    {
        $this->courseDocuments = new ArrayCollection();
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
            $courseDocument->setLabel($this);
        }

        return $this;
    }

    public function removeCourseDocument(CourseDocument $courseDocument): self
    {
        if ($this->courseDocuments->contains($courseDocument)) {
            $this->courseDocuments->removeElement($courseDocument);
            // set the owning side to null (unless already changed)
            if ($courseDocument->getLabel() === $this) {
                $courseDocument->setLabel(null);
            }
        }

        return $this;
    }

}
