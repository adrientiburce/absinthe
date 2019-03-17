<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseDocumentRepository")
 * @Vich\Uploadable
 */
class CourseDocument
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
     * @Vich\UploadableField(mapping="course_document", fileNameProperty="name")
     * @Assert\File(
    *     maxSize = "5000k",
    *     mimeTypes = {"application/pdf", "application/x-pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/msword"},
    *     mimeTypesMessage = "Veuillez sélectionner un PDF ou un Word"
    * )
     * @var File
     */
    private $document;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberOfUploads;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="courseDocuments")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Course", inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getNumberOfUploads(): ?int
    {
        return $this->numberOfUploads;
    }

    public function setNumberOfUploads(?int $numberOfUploads): self
    {
        $this->numberOfUploads = $numberOfUploads;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function setDocument(File $document = null)
    {
        $this->document = $document;
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($document instanceOf UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getDocument()
    {
        return $this->document;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
