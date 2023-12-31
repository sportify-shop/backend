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

    public function __construct(ManagerRegistry $registry, CategoryRepository $categoryRepository)
    {
        $this->categoryRepository;
        parent::__construct($registry, Product::class);
    }

    public function save($entity, $path, $category, bool $flush = false): void
    {
        $product = New Product();

        $availability = ($entity->getQuantity() !== null && $entity->getQuantity() > 0);
        $product->setName($entity->getName())
            ->setDescription($entity->getDescription())
            ->setPrice($entity->getPrice())
            ->setQuantity($entity->getQuantity())
            ->setAvailability($availability)
            ->setGender($entity->getGender())
            ->setImageSlug($path)
            ->setCategory($category);
        
        $this->getEntityManager()->persist($product);
            
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
   public function findByQueryParameters($name = null, $categoryId = null, $categoryName = null, $gender = null, $maxPrice = null, $orderBy = 'ASC'): array
   {

        $qb = $this->createQueryBuilder('p')
                ->select('p')
                ->join('p.category', 'c');

        if ($name !== null) {
            $qb->andWhere($qb->expr()->like('p.name', ':name'))
                ->setParameter('name', '%' . trim($name) . '%');
        } 

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
                ->setParameter('price', $maxPrice)
                ->orderBy('p.price', $orderBy);
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
