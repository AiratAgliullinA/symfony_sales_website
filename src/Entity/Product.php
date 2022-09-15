<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\Product\ImageHandler;
use Doctrine\ORM\Mapping as ORM;
use Money\Money;
use App\Converter\MoneyConverter;

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
     * @ORM\Column(type="string", length=128)
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
     * @ORM\Embedded(class="\Money\Money")
     */
    private $price;

    /**
     * Fake price for forms
     *
     * @param int
     */
    private $fakePrice;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $phone;

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
    public function getUser(): ?User
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
     * Set price
     *
     * @param int $price
     * @param string $currency
     *
     * @return self
     */
    public function setPrice(int $price, string $currency): self
    {
        $this->price = MoneyConverter::createMoneyObject($price, $currency);
        return $this;
    }

    /**
     * Get price
     *
     * @return Money
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency(): string
    {
        $price = $this->getPrice();

        return $price ? $price->getCurrency() : MoneyConverter::MAIN_CURRENCY_ISO;
    }

    /**
     * Set fake price
     *
     * @param int $fakePrice
     *
     * @return self
     */
    public function setFakePrice(int $fakePrice): self
    {
        $this->setPrice($fakePrice, $this->getCurrency());

        return $this;
    }

    /**
     * Get fake price
     *
     * @return int
     */
    public function getFakePrice()
    {
        $price = $this->getPrice();

        return $price ? $price->getAmount() : 0;
    }

    /**
     * Get display price
     *
     * @return string
     */
    public function getDisplayPrice(): string
    {
        $price = $this->getPrice();

        return MoneyConverter::getFormattedMoney($price);
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

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return self
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}