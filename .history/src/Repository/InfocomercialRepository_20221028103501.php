<?php

namespace App\Repository;

use App\Entity\Infocomercial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Infocomercial>
 *
 * @method Infocomercial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Infocomercial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Infocomercial[]    findAll()
 * @method Infocomercial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfocomercialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Infocomercial::class);
    }

    public function save(Infocomercial $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Infocomercial $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findbyNombreCategoria(string $nombreCategoria)
    {
        return $this->createQueryBuilder('m')
                ->innerJoin('m.categoria','c')
                ->where('c.nombre = :nombreCategoria')
                ->setParameter('nombreCategoria', $nombreCategoria)
                ->getQuery()
                ->getResult();
    }


//    /**
//     * @return Infocomercial[] Returns an array of Infocomercial objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Infocomercial
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
