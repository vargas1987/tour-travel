<?php

namespace AltezzaTravelBundle\Security;

use AltezzaTravelBundle\Entity\User;
use AltezzaTravelBundle\Service\UserAuthService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

/**
 * Class ServerHeaderTokenAuthenticator
 */
class ServerTokenAuthenticator implements SimplePreAuthenticatorInterface
{
    /**
     * @param Request $request
     * @param string  $providerKey
     * @return PreAuthenticatedToken
     */
    public function createToken(Request $request, $providerKey)
    {
        return new PreAuthenticatedToken('anon.', $request->get('token'), $providerKey);
    }

    /**
     * @param TokenInterface        $token
     * @param UserProviderInterface $userProvider
     * @param string                $providerKey
     * @return PreAuthenticatedToken
     * @throws CustomUserMessageAuthenticationException
     * @throws \Exception
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (!$userProvider instanceof UserAuthService) {
            $message = sprintf('The user provider must be an instance of UserAuthService (%s was given).', \get_class($userProvider));
            throw new \InvalidArgumentException($message);
        }

        $apiToken = $token->getCredentials();

        /** @var User $user */
        $user = $this->getUser($userProvider, $providerKey, $apiToken);

        if ($user) {
            $token = new PreAuthenticatedToken($user, $apiToken, $providerKey, $user->getRoles());
        }

        return $token;
    }

    /**
     * @param TokenInterface $token
     * @param string         $providerKey
     * @return bool
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * @param UserAuthService $userProvider
     * @param string          $providerKey
     * @param string          $token
     * @return User|null
     * @throws \Exception
     */
    protected function getUser(UserAuthService $userProvider, string $providerKey, string $token = null)
    {
        if (!$token) {
            return null;
        }

        return $userProvider->loadUserByToken($token);
    }
}
