<?php

namespace App\Repository;

use App\Entity\NiveauFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NiveauFormation>
 *
 * @method NiveauFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiveauFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiveauFormation[]    findAll()
 * @method NiveauFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiveauFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiveauFormation::class);
    }
}
