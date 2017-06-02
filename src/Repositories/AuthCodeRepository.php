<?php namespace Nord\Lumen\OAuth2\Doctrine\Repositories;

use Doctrine\ORM\EntityRepository;
use Nord\Lumen\OAuth2\Doctrine\Entities\AuthCode;

class AuthCodeRepository extends EntityRepository
{

    /**
     * @param string $code
     *
     * @return AuthCode|null|object
     */
    public function findByAuthCode($code)
    {
        return $this->findOneBy(['auth_code' => $code]);
    }
}
