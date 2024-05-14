<?php

namespace App\Repository;

use App\Entity\PortfolioPhotos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortfolioPhotos>
 *
 * @method PortfolioPhotos|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortfolioPhotos|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortfolioPhotos[]    findAll()
 * @method PortfolioPhotos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortfolioPhotosRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortfolioPhotos::class);
    }

    public function createQueryBuilderForPhotosBySlug(string $slug): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->join('p.photoCategory', 'pc')
            ->where('pc.slug = :slug')
            ->setParameter('slug', $slug);
    }

}