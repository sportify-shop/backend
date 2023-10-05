<?php

namespace App\Repository;

use DateTime;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\SubCategory;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\AST\Subselect;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    private $categoryRepository;
    private $subCategoryRepository;

    public function __construct(ManagerRegistry $registry, SubCategoryRepository $subCategoryRepository, CategoryRepository $categoryRepository)
    {
        $this->categoryRepository;
        $this->subCategoryRepository;
        parent::__construct($registry, Product::class);
    }

    public function save($entity, $category, $subCategory, bool $flush = false): void
    {
        $product = New Product();

        $availability = ($entity->getQuantity() !== null && $entity->getQuantity() > 0);
        $product->setName($entity->getName())
            ->setDescription($entity->getDescription())
            ->setPrice($entity->getPrice())
            ->setQuantity($entity->getQuantity())
            ->setAvailability($availability)
            ->setGender($entity->getGender())
            ->setImageSlug($entity->getImageSlug())
            ->setCategory($category)
            ->setSubCategory($subCategory);
        
        $this->getEntityManager()->persist($product);
            
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findProductsByCategoryId(int $categoryId): array
    {
        $products = $this->createQueryBuilder('p')
            ->andWhere('p.category = :category_id')
            ->setParameter('category_id', $categoryId)
            ->orderBy('p.id', 'ASC')
            ->getQuery();

        return $products->getResult();
    }

    public function findProductsByCategoryName(string $categoryName): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.category', 'c')
            ->andWhere('c.name = :name')
            ->setParameter('name', $categoryName)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findProductsBySubCategoryId(int $subCategoryId): array
    {
        $products = $this->createQueryBuilder('p')
            ->andWhere('p.subCategory = :sub_category_id')
            ->setParameter('sub_category_id', $subCategoryId)
            ->orderBy('p.id', 'ASC')
            ->getQuery();

        return $products->getResult();
    }

    public function findProductsByGender(string $gender): array
    {
        $products = $this->createQueryBuilder('p')
            ->where('p.gender = :gender')
            ->setParameter('gender', $gender)
            ->orderBy('p.id', 'ASC')
            ->getQuery();
        return $products->getResult();
            
    }

    public function findProductsByPrice(int $maxPrice): array
    {
        $products = $this->createQueryBuilder('p')
            ->where('p.price < :price')
            ->setParameter('price', $maxPrice)
            ->orderBy('p.id', 'ASC')
            ->getQuery();
        return $products->getResult();
            
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
   public function findByQueryParameters($categoryId = null, $categoryName = null, $gender = null, $maxPrice = null): array
   {

        $qb = $this->createQueryBuilder('p')
                ->select('p')
                ->join('p.category', 'c');

        if ($categoryId !== null) {
            $qb->andWhere('p.category = :category_id')
                ->setParameter('category_id', $categoryId);
        } 

        if ($categoryName !== null) {
            $qb->andWhere('c.name = :name')
                ->setParameter('name', trim($categoryName));
        }

        if ($gender !== null) {
            $qb->andWhere('p.gender = :gender')
                ->setParameter('gender', trim($gender));
        }

        if ($maxPrice !== null) {
            $qb->andWhere('p.price < :price')
                ->setParameter('price', $maxPrice);
        }
        
        return $qb->getQuery()->getResult();
   }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
