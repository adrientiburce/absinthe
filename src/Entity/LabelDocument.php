<?php

namespace App\Entity;

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
     * @ORM\OneToOne(targetEntity="App\Entity\CourseDocument", mappedBy="label", cascade={"persist", "remove"})
     */
    private $courseDocument;

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

    public function getCourseDocument(): ?CourseDocument
    {
        return $this->courseDocument;
    }

    public function setCourseDocument(CourseDocument $courseDocument): self
    {
        $this->courseDocument = $courseDocument;

        // set the owning side of the relation if necessary
        if ($this !== $courseDocument->getLabel()) {
            $courseDocument->setLabel($this);
        }

        return $this;
    }
}
