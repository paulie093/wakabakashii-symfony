<?php

namespace App\Repository\Project;

use App\Entity\Project\ProjectVideoQuality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectVideoQuality>
 *
 * @method ProjectVideoQuality|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectVideoQuality|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectVideoQuality[]    findAll()
 * @method ProjectVideoQuality[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectVideoQualityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectVideoQuality::class);
    }

    public function add(ProjectVideoQuality $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProjectVideoQuality $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ProjectVideoQuality[] Returns an array of ProjectVideoQuality objects
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

//    public function findOneBySomeField($value): ?ProjectVideoQuality
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
