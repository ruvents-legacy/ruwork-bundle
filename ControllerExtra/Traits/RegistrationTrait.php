<?php

namespace Ruvents\RuworkBundle\ControllerExtra\Traits;

use Ruvents\RuworkBundle\Security\AuthenticationHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

trait RegistrationTrait
{
    /**
     * @var AuthenticationHelper
     */
    private $authenticationHelper;

    /**
     * @required
     * @internal
     */
    final public function setAuthenticationHelper(AuthenticationHelper $authenticationHelper)
    {
        $this->authenticationHelper = $authenticationHelper;
    }

    public function authenticateUser(UserInterface $user, string $firewall, Response $response = null)
    {
        $this->authenticationHelper->authenticateUser($user, $firewall, $response);
    }
}
