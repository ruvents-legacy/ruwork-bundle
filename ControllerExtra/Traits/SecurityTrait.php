<?php

namespace Ruvents\RuworkBundle\ControllerExtra\Traits;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Core\User\UserInterface;

trait SecurityTrait
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @required
     * @internal
     */
    final public function setAuthorizationChecker(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @required
     * @internal
     */
    final public function setTokenStorage(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    protected function isGranted($attributes, $object = null): bool
    {
        return $this->authorizationChecker->isGranted($attributes, $object);
    }

    protected function isAuthenticatedRemembered(): bool
    {
        return $this->isGranted(AuthenticatedVoter::IS_AUTHENTICATED_REMEMBERED);
    }

    protected function isAuthenticatedFully(): bool
    {
        return $this->isGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY);
    }

    /**
     * @return UserInterface|null
     */
    protected function getUser()
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        if (!($user = $token->getUser()) instanceof UserInterface) {
            return null;
        }

        return $user;
    }
}
