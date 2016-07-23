<?php

namespace OC\PlatformBundle\Repository;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends \Doctrine\ORM\EntityRepository {

    public function findByAuthorAndDate($author, $date) {
        $qb = $this->createQueryBuilder('a');

        $qb->where("a.author = :author")
                ->setParameter("author", $author)
                ->andWhere("a.date < :date")
                ->setParameter("date", $date)
                ->orderBy("a.date", "DESC");
        return $qb->getQuery()->getResult();
    }

    public function getAdvertWithApplications() {
        $qb = $this->createQueryBuilder("a")
                ->leftJoin("a.applications", "app")
                ->addSelect("app");

        return $qb->getQuery()->getResult();
    }

    public function getAdvertWithCategory(array $categoryNames) {
        $qb = $this->createQueryBuilder("a")
                ->innerJoin("a.categories", "category")
                ->addSelect("category")
                ->where($qb->expr()->in("category.name", "(:categories)"))
                ->setParameter("categories", $categoryNames);

        $qb->getQuery()->getResult();
    }

}
