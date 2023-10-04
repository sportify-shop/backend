<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Entity\Order;
use App\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderProductRepository;

#[ORM\Entity(repositoryClass: OrderProductRepository::class)]
// #[ORM\HasLifecycleCallbacks]

class OrderProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?DateTimeImmutable $createdAt = null;

    // #[ORM\Column]
    // #[Assert\NotNull()]
    // private ?DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'orderProducts')]
    #[JoinColumn(name: 'order_id', referencedColumnName: 'id')]
    private ?Order $order = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'orderProducts')]
    #[JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private ?Product $product = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        // $this->updatedAt = new DateTimeImmutable();
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

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
