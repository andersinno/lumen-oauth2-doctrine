<?php namespace Nord\Lumen\OAuth2\Doctrine\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Nord\Lumen\OAuth2\Doctrine\Repositories\SessionRepository")
 * @ORM\Table(name="oauth_sessions")
 */
class Session extends Entity
{
    const OWNER_TYPE_USER = 'user';
    const OWNER_TYPE_CLIENT = 'client';

    /**
     * @ORM\Column(type="string", name="owner_type")
     * @var string
     */
    protected $ownerType = self::OWNER_TYPE_USER;

    /**
     * @ORM\Column(type="string", name="owner_id")
     * @var string
     */
    protected $ownerId;

    /**
     * @ORM\ManyToOne(targetEntity="Nord\Lumen\OAuth2\Doctrine\Entities\Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", onDelete="CASCADE")
     * @var Client
     */
    protected $client;

    /**
     * @ORM\Column(type="string", name="client_redirect_uri", nullable=true)
     * @var string
     */
    protected $clientRedirectUri;


    /**
     * Session constructor.
     *
     * @param string $ownerType
     * @param string $ownerId
     * @param Client $client
     * @param string|null $clientRedirectUri
     */
    public function __construct($ownerType, $ownerId, Client $client, $clientRedirectUri = null)
    {
        $this->ownerType         = $ownerType;
        $this->ownerId           = $ownerId;
        $this->client            = $client;
        $this->clientRedirectUri = $clientRedirectUri;
    }


    /**
     * @return string
     */
    public function getOwnerType()
    {
        return $this->ownerType;
    }


    /**
     * @return string
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getClientRedirectUri()
    {
        return $this->clientRedirectUri;
    }
}
