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
     * Add substring condition
     *
     * @param QueryBuilder $queryBuilder
     * @param string $substring
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function addSubstringCondition(QueryBuilder $queryBuilder, string $substring, string $alias = '')
    {
        $alias = $alias ?: $queryBuilder->getRootAlias();

        return $queryBuilder
            ->andWhere($alias . '.name LIKE :substring')
            ->setParameter('substring', '%' . $substring . '%');
    }

    /**
     * Add userid condition
     *
     * @param QueryBuilder $queryBuilder
     * @param int $userId
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function addUserIdCondition(QueryBuilder $queryBuilder, int $userId, string $alias = '')
    {
        $alias = $alias ?: $queryBuilder->getRootAlias();

        return $queryBuilder
            ->andWhere($alias . '.user = :user')
            ->setParameter('user', $userId);
    }

    /**
     * Add status condition
     *
     * @param QueryBuilder $queryBuilder
     * @param int $status
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function addStatusCondition(QueryBuilder $queryBuilder, int $status, string $alias = '')
    {
        $alias = $alias ?: $queryBuilder->getRootAlias();

        return $queryBuilder
            ->andWhere($alias . '.status = :status')
            ->setParameter('status', $status);
    }
}