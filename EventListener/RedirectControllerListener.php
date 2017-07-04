<?php

namespace Ruwork\CoreBundle\EventListener;

use Ruwork\CoreBundle\ControllerAnnotations\Redirect;
use Ruwork\CoreBundle\ExpressionLanguage\RedirectExpressionLanguage;
use Sensio\Bundle\FrameworkExtraBundle\Security\ExpressionLanguage as SecurityExpressionLanguage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
    private $securityLanguage;

    /**
     * @var RedirectExpressionLanguage
     */
    private $redirectLanguage;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(
        ControllerResolverInterface $controllerResolver,
        SecurityExpressionLanguage $securityLanguage,
        RedirectExpressionLanguage $redirectLanguage,
        AuthorizationCheckerInterface $authChecker = null,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->controllerResolver = $controllerResolver;
        $this->securityLanguage = $securityLanguage;
        $this->redirectLanguage = $redirectLanguage;
        $this->authChecker = $authChecker;
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

        /** @var Redirect[] $redirects */
        $redirects = $request->attributes->get('_ruwork.redirect', []);

        foreach ($redirects as $redirect) {
            $condition = $this->securityLanguage->evaluate($redirect->getCondition(), [
                'request' => $request,
                'auth_checker' => $this->authChecker,
            ]);

            if (!$condition) {
                continue;
            }

            $request->attributes->set('_controller', 'FrameworkBundle:Redirect:urlRedirect');

            $controller = $this->controllerResolver->getController($request);

            $url = $this->redirectLanguage->evaluate($redirect->getUrl(), [
                'request' => $request,
                'url_generator' => $this->urlGenerator,
            ]);

            $request->attributes->set('permanent', $redirect->getPermanent());
            $request->attributes->set('path', $url);

            $event->setController($controller);

            return;
        }
    }
}
