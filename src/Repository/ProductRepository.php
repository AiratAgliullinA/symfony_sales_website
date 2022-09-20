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
     *
     * @return void
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Add entity
     *
     * @param Product $entity
     * @param bool $flush
     *
     * @return void
     */
    public function add(Product $entity, bool $flush = true): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);

        if ($flush) {
            $entityManager->flush();
        }
    }

    /**
     * Remove entity
     *
     * @param Product $entity
     * @param bool $flush
     *
     * @return void
     */
    public function remove(Product $entity, bool $flush = true): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($entity);

        if ($flush) {
            $entityManager->flush();
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

    /**
     * Add categoryId condition
     *
     * @param QueryBuilder $queryBuilder
     * @param int $categoryId
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function addCategoryIdCondition(QueryBuilder $queryBuilder, int $categoryId, string $alias = '')
    {
        $alias = $alias ?: $queryBuilder->getRootAlias();

        return $queryBuilder
            ->andWhere($alias . '.category = :category')
            ->setParameter('category', $categoryId);
    }
}