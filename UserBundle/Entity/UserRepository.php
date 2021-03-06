<?php

namespace Application\UserBundle\Entity;

use Application\ClanBundle\Entity\Clan;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function findAllEnabled()
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.enabled = 1');

        return $qb;
    }

    /**
     * @param $role
     * @param bool $enabledOnly
     * @return QueryBuilder
     */
    public function getAllByRole($role, $enabledOnly = false)
    {
        $qb = $this->createQueryBuilder('a');

        if (is_array($role)) {

            foreach ($role as $key => $_role) {

                $qb->orWhere($qb->expr()->like('a.roles', ':role' . $key));
                $qb->setParameter('role' . $key, "%{$_role}%");
            }

        } else {
            $qb->where($qb->expr()->like('a.roles', ':role'));
            $qb->setParameter('role', "%{$role}%");
        }

        if ($enabledOnly) {
            $qb->andWhere('a.enabled = 1');
        }

        return $qb;
    }

    /**
     * @return array
     */
    public function getCountByStatus()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('a.roles, count(a.id) AS total');

        $qb->groupBy('a.roles');

        $summary = array();

        $result = $qb->getQuery()->getResult();

        if ($result) {
            $total = 0;

            foreach ($result as $row) {

                if ($row['roles']) {
                    $summary[$row['roles'][0]] = $row['total'] + 0;
                }
                $total += $row['total'];
            }

            $summary['all'] = $total;
        }

        return $summary;
    }


    /**
     * @param Clan $clan
     * @param array $tagsArray
     * @return QueryBuilder
     */
    public function getClanUsersNotInTags(Clan $clan, array $tagsArray)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where('a.clan = :clan');
        $qb->andWhere($qb->expr()->notIn('a.tag', ':tagsArray'));

        $qb->setParameter('clan', $clan);
        $qb->setParameter('tagsArray', $tagsArray);

        return $qb;
    }

    /**
     * @param User $user
     * @return QueryBuilder
     */
    public function getUserWithCards(User $user)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where('a.id = :user');
        $qb->setParameter('user', $user);

        $qb->leftJoin('a.userCards', 'uc')->addSelect('uc');

        return $qb;
    }

    /**
     * @param Clan $clan
     * @param array $orderByArray
     * @return QueryBuilder
     */
    public function getClanUsersWithCards(Clan $clan, $orderByArray = array())
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where('a.clan = :clan');
        $qb->setParameter('clan', $clan);

        $qb->leftJoin('a.userCards', 'uc')->addSelect('uc');
        $qb->leftJoin('uc.card', 'c')->addSelect('c');

        if ($orderByArray) {
            foreach ($orderByArray as $orderBy => $orderType) {
//                $qb->orderBy('a.utcTime', $order);
                $qb->orderBy($orderBy, $orderType);
            }
        }

        return $qb;
    }

    /**
     * @param $search
     * @param int $limit
     * @return QueryBuilder
     */
    public function searchUserBy($search, $limit = 0)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where('a.enabled = 1');


        $searchArray = explode(' ', $search);

        foreach ($searchArray as $key => $searchTerm) {

            $searchKey = ":search{$key}";

            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('a.username', $searchKey),
                $qb->expr()->like('a.tag', $searchKey)
            ));

            $qb->setParameter("search{$key}", '%' . $searchTerm . '%');
        }

        if ($limit) {
            $qb->setMaxResults($limit);
        }

//        $qb->orderBy('a.updatedAt', 'DESC');

        return $qb;
    }
}
