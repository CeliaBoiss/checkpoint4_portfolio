<?php

namespace App\Repository;

use App\Entity\WorkingPartner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkingPartner|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkingPartner|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkingPartner[]    findAll()
 * @method WorkingPartner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkingPartnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkingPartner::class);
    }
}
