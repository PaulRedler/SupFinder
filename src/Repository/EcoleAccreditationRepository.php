<?php

namespace App\Repository;

use App\Entity\EcoleAccreditation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EcoleAccreditation>
 *
 * @method EcoleAccreditation|null find($id, $lockMode = null, $lockVersion = null)
 * @method EcoleAccreditation|null findOneBy(array $criteria, array $orderBy = null)
 * @method EcoleAccreditation[]    findAll()
 * @method EcoleAccreditation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EcoleAccreditationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EcoleAccreditation::class);
    }
}
