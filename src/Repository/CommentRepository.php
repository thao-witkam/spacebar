<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    static function noneDeletedCriteria($orderBy = ['createdAt' => 'DESC'])
    {
        return Criteria::create()
            ->andWhere(Criteria::expr()->isNull('deletedAt'))
            ->orderBy($orderBy);
    }

    /**
     * @param string $searchTerm
     * @return \Doctrine\ORM\QueryBuilder
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function getSearchQueryBuilder(string $searchTerm = null)
    {
        $qBuilder = $this->createQueryBuilder('c')
            ->innerJoin('c.article', 'a')
            ->addSelect('a')
            ->addCriteria(self::noneDeletedCriteria());

        if ($searchTerm !== null and !empty($searchTerm)) {
            $qBuilder->andWhere('a.title LIKE :term OR a.content LIKE :term OR c.authorName LIKE :term OR c.content LIKE :term')
                ->setParameter('term', "%{$searchTerm}%");
        }

        return $qBuilder;
    }

}
