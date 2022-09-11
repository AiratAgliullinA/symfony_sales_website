<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

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
    /**
     * Constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Add
     *
     * @param Product $entity
     * @param bool $flush
     *
     * @return void
     */
    public function add(Product $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Remove
     *
     * @param Product $entity
     * @param bool $flush
     *
     * @return void
     */
    public function remove(Product $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Define find all items
     *
     * @return QueryBuilder
     */
    public function defineFindAllQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    /**
     * Define find by substring
     *
     * @param string substring
     *
     * @return QueryBuilder
     */
    public function defineFindBySubstringQuery(string $substring): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name LIKE :substring')
            ->setParameter('substring', '%' . $substring . '%');
    }

    /**
     * Define find by user id
     *
     * @param int $userId
     *
     * @return QueryBuilder
     */
    public function defineFindByUserIdQuery(int $userId): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $userId);
    }
}