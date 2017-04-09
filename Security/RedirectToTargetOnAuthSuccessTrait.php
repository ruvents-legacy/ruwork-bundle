<?php

namespace Ruwork\CoreBundle\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

trait RedirectToTargetOnAuthSuccessTrait
{
    use TargetPathTrait;

    /**
     * @see GuardAuthenticatorInterface::onAuthenticationSuccess()
     *
     * @param Request        $request
     * @param TokenInterface $token
     * @param string         $providerKey
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->getTargetPath($this->getSession(), $providerKey));
    }

    /**
     * @return Session
     */
    abstract protected function getSession();
}
