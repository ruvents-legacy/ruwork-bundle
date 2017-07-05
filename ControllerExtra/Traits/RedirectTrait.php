<?php

namespace Ruvents\RuworkBundle\ControllerExtra\Traits;

use Symfony\Component\HttpFoundation\RedirectResponse;

trait RedirectTrait
{
    use UrlGeneratorTrait;

    protected function permanentRedirect(string $route, array $parameters = []): RedirectResponse
    {
        return new RedirectResponse($this->generateUrl($route, $parameters), 301);
    }

    protected function temporaryRedirect(string $route, array $parameters = []): RedirectResponse
    {
        return new RedirectResponse($this->generateUrl($route, $parameters), 302);
    }
}
