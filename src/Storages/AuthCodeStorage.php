<?php namespace Nord\Lumen\OAuth2\Doctrine\Storages;

use Carbon\Carbon;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Storage\AuthCodeInterface;
use Nord\Lumen\OAuth2\Doctrine\Entities\AuthCode;
use Nord\Lumen\OAuth2\Doctrine\Repositories\AuthCodeRepository;
use Nord\Lumen\OAuth2\Doctrine\Repositories\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Entity\ScopeEntity;
use Nord\Lumen\OAuth2\Doctrine\Entities\Session;

class AuthCodeStorage extends DoctrineStorage implements AuthCodeInterface
{

    /**
     * @var AuthCodeRepository
     */
    protected $authCodeRepository;

    /**
     * @var SessionRepository
     */
    protected $sessionRepository;


    /**
     * AccessTokenStorage constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        $this->authCodeRepository = $this->entityManager->getRepository(AuthCode::class);
        $this->sessionRepository = $this->entityManager->getRepository(Session::class);
    }


    /**
     * @inheritdoc
     */
    public function get($code)
    {
        $authCode = $this->authCodeRepository->findByAuthCode($code);

        if ($authCode instanceof AuthCode) {
            return $this->createEntity($authCode);
        }

        return null;
    }


    /**
     * @inheritdoc
     */
    public function getScopes(AuthCodeEntity $token)
    {
    }


    /**
     * @inheritdoc
     */
    public function create($token, $expireTime, $sessionId, $redirectUri)
    {
        /** @var Session $session */
        $session = $this->sessionRepository->find($sessionId);

        $accessToken = new AuthCode($token, $session, $redirectUri, Carbon::createFromTimestamp($expireTime));

        $this->entityManager->persist($accessToken);
        $this->entityManager->flush($accessToken);
    }


    /**
     * @inheritdoc
     */
    public function associateScope(AuthCodeEntity $token, ScopeEntity $scope)
    {
        throw new \Exception('Not implemented');
    }


    /**
     * @inheritdoc
     */
    public function delete(AuthCodeEntity $token)
    {
        $authCode = $this->authCodeRepository->findByAuthCode($token->getId());

        if ($authCode instanceof AuthCode) {
            $this->entityManager->remove($authCode);
            $this->entityManager->flush($authCode);
        }
    }


    /**
     * @param AuthCode $authCode
     *
     * @return AuthCodeEntity
     */
    protected function createEntity(AuthCode $authCode)
    {
        $entity = new AuthCodeEntity($this->server);
        $entity->setId($authCode->getAuthCode());
        $entity->setRedirectUri($authCode->getRedirectUri());
        $entity->setExpireTime($authCode->getExpireTime()->getTimestamp());

        return $entity;
    }
}
