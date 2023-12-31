<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
// #[ORM\HasLifecycleCallbacks]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private ?string $name;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description;

    #[ORM\Column]
    private ?float $price;

    #[ORM\Column]
    private ?int $quantity;

    #[ORM\Column]
    private ?bool $availability;

    #[ORM\Column(length: 255)]
    private ?string $gender;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $image_slug;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?DateTimeImmutable $createdAt;

    // #[ORM\Column]
    // #[Assert\NotNull()]
    // private ?DateTimeImmutable $updatedAt;


    // Bidirectional ManyToOne relationship with Category
    /** Many products have one category. This is the owning side. */
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy:'products', cascade: ['persist'])]
    #[JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private Category $category;

    #[ORM\OneToMany(targetEntity: OrderProduct::class, mappedBy: 'product')]
    private Collection $orderProducts;

    public function __construct() 
    {
        // $this->updatedAt = new DateTimeImmutable();
        $this->createdAt = new DateTimeImmutable();
        $this->orderProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function isAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $availability): static
    {
        $this->availability = $availability;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getImageSlug(): ?string
    {
        return $this->image_slug;
    }

    public function setImageSlug(string $image_slug): static
    {
        $this->image_slug = $image_slug;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    // public function getUpdatedAt(): ?DateTimeImmutable
    // {
    //     return $this->updatedAt;
    // }

    // public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    // {
    //     $this->updatedAt = $updatedAt;

    //     return $this;
    // }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addorderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->add($orderProduct);
            $orderProduct->setProduct($this);
        }

        return $this;
    }


    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        $this->orderProducts->removeElement($orderProduct);
        
        return $this;
    }
}
