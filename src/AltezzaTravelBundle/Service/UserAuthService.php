<?php

namespace AltezzaTravelBundle\Service;

use AltezzaTravelBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class UserAuthService
 */
class UserAuthService implements UserProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * UserAuthService constructor.
     * @param EntityManagerInterface $em
     * @param LoggerInterface        $logger
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        $userRepository = $this->em->getRepository(User::class);

        return $userRepository->getClassName() === $class || is_subclass_of($class, $userRepository->getClassName());
    }

    /**
     * @param UserInterface $user
     * @return User
     * @throws \Exception
     */
    public function refreshUser(UserInterface $user)
    {
        /* @var User $user */
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', $class)
            );
        }
        try {
            $user = $this->em->getRepository(User::class)->find($user->getId());
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            throw new CustomUserMessageAuthenticationException('Unexpected error occurred.');
        }

        return $user;
    }

    /**
     * @param string $username
     * @return User
     * @throws \Exception
     */
    public function loadUserByUsername($username)
    {
        try {
            $user = $this->em->getRepository(User::class)->findOneBy([
                'email' => $username,
            ]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            throw new CustomUserMessageAuthenticationException('Unexpected error occurred.');
        }
        if (!$user) {
            $message = sprintf('Unable to find an active user identified by "%s".', $username);
            throw new UsernameNotFoundException($message);
        }

        return $user;
    }

    /**
     * @param string $token
     * @return User
     * @throws \Exception
     */
    public function loadUserByToken($token)
    {
        $user = null;
        try {
            $user = $this->em->getRepository(User::class)->findOneBy([
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            throw new CustomUserMessageAuthenticationException('Unexpected error occurred.');
        }

        return $user;
    }
}
