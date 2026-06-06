<?php

declare(strict_types=1);

namespace App\Authentication\Repository;

use App\Authentication\Entity\UserOauth;
use Doctrine\ORM\EntityRepository;

/**
 * @extends EntityRepository<UserOauth>
 */
class UserOauthRepository extends EntityRepository
{
}
