<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\Product\ImageHandler;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $shortDescription;

    /**
     * User
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="products")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $imageFilename;

    /**
     * @param boolean
     */
    private $isRemoveImage;

    /**
     * Get object unique id
     *
     * @return integer
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set short description
     *
     * @param string $shortDescription
     *
     * @return self
     */
    public function setShortDescription($shortDescription): self
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * Get short description
     *
     * @return string
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Set image file name
     *
     * @param string $imageFilename
     *
     * @return self
     */
    public function setImageFilename(string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;
        return $this;
    }

    /**
     * Get image file name
     *
     * @return string
     */
    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    /**
     * Delete image product
     *
     * @param ImageHandler $imageHandler
     *
     * @return void
     */
    public function deleteImageProduct(ImageHandler $imageHandler)
    {
        if ($imageFilename = $this->getImageFilename()) {
            $this->setImageFilename('');
            $imageHandler->remove($imageFilename);
        }
    }

    /**
     * Upload image product
     *
     * @param UploadedFile $imageFile
     * @param ImageHandler $imageHandler
     *
     * @return void
     */
    public function uploadImageProduct(UploadedFile $imageFile, ImageHandler $imageHandler)
    {
        $imageFilename = $imageHandler->upload($imageFile);
        $this->setImageFilename($imageFilename);
    }

    /**
     * Set isRemoveImage
     *
     * @param boolean $isRemoveImage
     *
     * @return self
     */
    public function setIsRemoveImage($isRemoveImage): self
    {
        $this->isRemoveImage = $isRemoveImage;
        return $this;
    }

    /**
     * Get isRemoveImage
     *
     * @return boolean
     */
    public function getIsRemoveImage(): ?bool
    {
        return $this->isRemoveImage;
    }
}