<?php

namespace Ruvents\RuworkBundle\ControllerExtra\Traits;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

trait LoginTrait
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * @required
     * @internal
     */
    final public function setAuthenticationHelper(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @return AuthenticationException|null
     */
    protected function getLastAuthenticationError()
    {
        return $this->authenticationUtils->getLastAuthenticationError();
    }

    /**
     * @return string|null
     */
    protected function getLastUsername()
    {
        return $this->authenticationUtils->getLastUsername();
    }
}
