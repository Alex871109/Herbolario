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



    public function findByUso(Usos $uso)    //Como el miembro uso, es 1 collection, o sea un array, no existe el metodo magico findByUso
{                                           // Este metodo lo hace a mano.    https://www.doctrine-project.org/projects/doctrine-orm/en/2.13/reference/working-with-associations.html#association-management-methods
    return $this->createQueryBuilder("p")
            ->where(':uso MEMBER OF p.uso')
            ->setParameters(['uso' => $uso])
            ->getQuery()->getResult();
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
