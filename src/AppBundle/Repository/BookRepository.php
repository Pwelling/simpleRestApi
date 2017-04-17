<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BookRepository extends EntityRepository
{
    /**
     * @param string $keyword
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function findByKeyword(string $keyword, $limit = null, $offset = null)
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('b')
            ->from('AppBundle:Book', 'b')
            ->join('b.author', 'a')
            ->join('b.publisher', 'p')
            ->where('b.title LIKE :search')
            ->orWhere('a.name LIKE :search')
            ->orWhere('p.name LIKE :search')
            ->setParameter('search', '%' . $keyword . '%');
        if (!is_null($limit)) {
            $queryBuilder->setMaxResults($limit);
        }
        if (!is_null($offset)) {
            $queryBuilder->setFirstResult($offset);
        }
        return $queryBuilder->getQuery()->getResult();
    }
}
