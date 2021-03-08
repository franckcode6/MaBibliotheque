<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findAll()
    {
        $qb = $this->createQueryBuilder('b');
        $qb->orderBy('b.title', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function searchInName(string $title)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->where('b.title LIKE :title')
            ->setParameter('title', '%' . $title . '%')
            ->orderBy('b.title', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
