<?php

namespace Ruvents\RuworkBundle\ControllerExtra\Traits;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

trait UrlGeneratorTrait
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @required
     * @internal
     */
    final public function setUrlGenerator(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    protected function generateUrl(
        string $route,
        $parameters = [],
        int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH
    ): string {
        return $this->urlGenerator->generate($route, $parameters, $referenceType);
    }
}
