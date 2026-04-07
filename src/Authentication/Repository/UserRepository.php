<?php

declare(strict_types=1);

namespace App\Authentication\Repository;

use App\Authentication\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends EntityRepository<User>
 */
class UserRepository extends EntityRepository
{
    /**
     * @return Paginator<User>
     */
    public function getPaginatedUsers(int $page = 1, int $limit = 1, ?string $search = null): Paginator
    {
        $query = $this->createQueryBuilder('u')->orderBy('u.id', 'DESC');

        if ($search) {
            $query->andWhere('u.email LIKE :search')->setParameter('search', '%' . $search . '%');
        }

        $query->setFirstResult(($page - 1) * $limit)->setMaxResults($limit);

        /**
         * @var Paginator<User> $paginator
         */
        $paginator = new Paginator($query);

        return $paginator;
    }
}
