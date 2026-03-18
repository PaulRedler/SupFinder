<?php

namespace App\Repository;

use App\Entity\TypeEcole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeEcole>
 *
 * @method TypeEcole|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeEcole|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeEcole[]    findAll()
 * @method TypeEcole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeEcoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeEcole::class);
    }
}
