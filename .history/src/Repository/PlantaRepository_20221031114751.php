<?php

namespace App\Repository;

use App\Entity\Planta;
use App\Entity\Usos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Planta>
 *
 * @method Planta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planta[]    findAll()
 * @method Planta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlantaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planta::class);
    }

    public function save(Planta $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Planta $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



    public function findByUso(Usos $uso)
{
    $qb = $this->createQueryBuilder("p")
        ->where(':platform MEMBER OF p.platforms')
        ->setParameters(array('platform' => $platform))
    ;
    return $qb->getQuery()->getResult();
}

//    /**
//     * @return Planta[] Returns an array of Planta objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Planta
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
