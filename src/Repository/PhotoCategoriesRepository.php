<?php

namespace App\Repository;

use App\Entity\PhotoCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PhotoCategories>
 *
 * @method PhotoCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoCategories[]    findAll()
 * @method PhotoCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoCategories::class);
    }

}
