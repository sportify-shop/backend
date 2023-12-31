<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
// #[ORM\HasLifecycleCallbacks]
// #[UniqueEntity(fields: ['name'], message: 'There is already a category with this name')]

class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?DateTimeImmutable $createdAt = null;

    // #[ORM\Column]
    // #[Assert\NotNull()]
    // private ?DateTimeImmutable $updatedAt = null;

    #[OneToMany(targetEntity: Product::class, mappedBy: 'category', cascade: ['persist', 'remove'])]
    private Collection $products;

    public function __construct() 
    {
        // $this->updatedAt = new DateTimeImmutable();
        $this->createdAt = new DateTimeImmutable();
        $this->products = new ArrayCollection();
    }

    // #[ORM\PreUpdate]
    // public function preUpdate()
    // {
    //     $this->updatedAt = new DateTimeImmutable();
    // }

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

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) 
        {
            $this->products->add($product);
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);
        
        return $this;
    }
}
