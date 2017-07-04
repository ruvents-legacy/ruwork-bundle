<?php

namespace Ruwork\CoreBundle\EventListener;

use Ruwork\CoreBundle\ControllerAnnotations\Redirect;
use Ruwork\CoreBundle\ExpressionLanguage\UrlExpressionLanguage;
use Sensio\Bundle\FrameworkExtraBundle\Security\ExpressionLanguage as SecurityExpressionLanguage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RedirectControllerListener implements EventSubscriberInterface
{
    /**
     * @var ControllerResolverInterface
     */
    private $controllerResolver;

    /**
     * @var SecurityExpressionLanguage
     */
    private $conditionLanguage;

    /**
     * @var UrlExpressionLanguage
     */
    private $urlLanguage;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(
        ControllerResolverInterface $controllerResolver,
        SecurityExpressionLanguage $conditionLanguage,
        UrlExpressionLanguage $urlLanguage,
        AuthorizationCheckerInterface $authChecker = null,
        TokenStorageInterface $tokenStorage,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->controllerResolver = $controllerResolver;
        $this->conditionLanguage = $conditionLanguage;
        $this->urlLanguage = $urlLanguage;
        $this->authChecker = $authChecker;
        $this->tokenStorage = $tokenStorage;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -200],
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        $redirects = $request->attributes->get('_ruwork.redirect', []);

        foreach ($redirects as $redirect) {
            if (!$redirect instanceof Redirect) {
                continue;
            }

            $condition = $this->conditionLanguage
                ->evaluate($redirect->getCondition(), $this->getConditionVars($request));

            if (!$condition) {
                continue;
            }

            $request->attributes->set('_controller', 'FrameworkBundle:Redirect:urlRedirect');

            $controller = $this->controllerResolver->getController($request);

            if (false === $controller) {
                return;
            }

            $url = $this->urlLanguage
                ->evaluate($redirect->getUrl(), $this->getUrlVars($request));

            $request->attributes->set('permanent', $redirect->getPermanent());
            $request->attributes->set('path', $url);

            $event->setController($controller);

            return;
        }
    }

    private function getConditionVars(Request $request): array
    {
        return array_merge(
            $request->attributes->all(),
            [
                'request' => $request,
                'user' => $this->tokenStorage->getToken()->getUser(),
                'object' => $request,
                'auth_checker' => $this->authChecker,
            ]
        );
    }

    private function getUrlVars(Request $request): array
    {
        return array_merge(
            $request->attributes->all(),
            [
                'request' => $request,
                'url_generator' => $this->urlGenerator,
            ]
        );
    }
}
