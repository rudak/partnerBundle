<?php

namespace Rudak\PartnerBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PartnerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PartnerRepository extends EntityRepository
{
    public function getPartnerById($id)
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('pic')
            ->leftJoin('p.picture', 'pic')
            ->where('p.id = :id')->setParameter('id', $id)
            ->getQuery();
        return $qb->getOneOrNullResult();
    }

    /**
     * admin
     */
    public function getPartnersList()
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('pic')
            ->addSelect('c')
            ->leftJoin('p.picture', 'pic')
            ->leftJoin('p.category', 'c')
            ->orderBy('p.current', 'DESC')
            ->addOrderBy('p.category', 'ASC')
            ->addOrderBy('p.id', 'DESC')
            ->getQuery();
        return $qb->execute();
    }
}
