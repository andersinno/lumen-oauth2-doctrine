<?php namespace Nord\Lumen\OAuth2\Doctrine\Entities;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Nord\Lumen\OAuth2\Doctrine\Repositories\AuthCodeRepository")
 * @ORM\Table(name="oauth_auth_codes")
 */
class AuthCode extends Entity
{

    /**
     * @ORM\Column(type="string", name="auth_code")
     * @var string
     */
    protected $authCode;

    /**
     * @ORM\ManyToOne(targetEntity="Nord\Lumen\OAuth2\Doctrine\Entities\Session")
     * @ORM\JoinColumn(name="session_id", referencedColumnName="id", onDelete="CASCADE")
     * @var Session
     */
    protected $session;

    /**
     * @ORM\Column(type="datetime", name="expire_time")
     * @var Carbon
     */
    protected $expireTime;

    /**
     * @ORM\Column(type="string", name="client_redirect_uri")
     * @var string
     */
    protected $redirectUri;


    /**
     * AccessToken constructor.
     *
     * @param string $authCode
     * @param Session $session
     * @param string $redirectUri
     * @param Carbon $expireTime
     */
    public function __construct($authCode, Session $session, $redirectUri, Carbon $expireTime)
    {
        $this->authCode    = $authCode;
        $this->session     = $session;
        $this->expireTime  = $expireTime;
        $this->redirectUri = $redirectUri;
    }


    /**
     * @return string
     */
    public function getAuthCode()
    {
        return $this->authCode;
    }


    /**
     * @return Carbon
     */
    public function getExpireTime()
    {
        return $this->expireTime;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }
}
