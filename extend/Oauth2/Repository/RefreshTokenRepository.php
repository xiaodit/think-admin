<?php

namespace Oauth2\Repository;

use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Creates a new refresh token
     *
     * @return RefreshTokenEntityInterface|null
     */
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }

    /**
     * Create a new refresh token_name.
     *
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $this->db::table('oauth_refresh_tokens')->insert([
            'refresh_token' => $refreshTokenEntity->getIdentifier(),
            'expires' => $refreshTokenEntity->getExpiryDateTime()->getTimestamp(),
            'access_token' => $refreshTokenEntity->getAccessToken()->getIdentifier(),
        ]);
    }

    /**
     * Revoke the refresh token.
     *
     * @param string $tokenId
     */
    public function revokeRefreshToken($tokenId)
    {
        $this->db::table("oauth_refresh_tokens")->where('refresh_token', $tokenId)->update(['revoked' => true]);
    }

    /**
     * Check if the refresh token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        $row = $this->db::table('oauth_refresh_tokens')->where('refresh_token', $tokenId)->field('revoked')->find();
        return $row ? $row["revoked"] : true;
    }
}
