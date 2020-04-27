<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtisticWorkRepository")
 * @Vich\Uploadable()
 * @ApiResource
 */
class Travaux
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
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

     /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
     private $picture;

       /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="picture")
     * @Assert\File(
     * maxSize="1000k",
     * maxSizeMessage="Le fichier excède 1000Ko.",
     * mimeTypes={"image/png", "image/jpeg", "image/jpg", "image/gif"},
     * mimeTypesMessage= "formats autorisés: png, jpeg, jpg, gif"
     * )
     * @var File|null
     */
    private $pictureFile;

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

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

     /**
     * @ORM\Column(type="datetime")
     * @var datetime|null
     */
     private $createdAt;


    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

     /**
     * @return null|string
     */
     public function getPictureFile(): ?File
     { 
     return $this->pictureFile;
     }
 
     /**
      * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $PictureFile
      * @return Travaux
      */
     public function setPictureFile(?File $pictureFile): Travaux
     {
         $this->pictureFile = $pictureFile;
         if ($this->pictureFile instanceof UploadedFile) {
             $this->updated_at = new \DateTime('now');
         }
 
         return $this;
     }

     public function getCreatedAt(): ?\DateTimeInterface
     {
         return $this->createdAt;
     }
 
     public function setCreatedAt(\DateTimeInterface $createdAt): self
     {
         $this->createdAt = $createdAt;
 
         return $this;
     }

     public function getUpdatedAt(): ?\DateTimeInterface
     {
         return $this->updated_at;
     }
 
     public function setUpdatedAt(\DateTimeInterface $updated_at): self
     {
         $this->updated_at = $updated_at;
 
         return $this;
     }
 
 
}
