<?php

namespace Ruvents\RuworkBundle\Doctrine\AuthorProvider;

use Ruvents\DoctrineBundle\AuthorProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityTokenAuthorProvider implements AuthorProviderInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthor()
    {
        $token = $this->tokenStorage->getToken();

        if (null !== $token && is_object($user = $token->getUser())) {
            return $user;
        }

        return null;
    }
}
