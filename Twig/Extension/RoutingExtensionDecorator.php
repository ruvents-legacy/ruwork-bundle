<?php

namespace Ruvents\RuworkBundle\Twig\Extension;

use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RoutingExtensionDecorator extends AbstractExtension
{
    /**
     * @var RoutingExtension
     */
    private $decorated;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var PropertyAccessorInterface
     */
    private $accessor;

    public function __construct(RoutingExtension $decorated, RouterInterface $router, PropertyAccessorInterface $accessor = null)
    {
        $this->decorated = $decorated;
        $this->router = $router;
        $this->accessor = $accessor ?? PropertyAccess::createPropertyAccessor();
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('url', [$this, 'getUrl'], ['is_safe_callback' => [$this->decorated, 'isUrlGenerationSafe']]),
            new TwigFunction('path', [$this, 'getPath'], ['is_safe_callback' => [$this->decorated, 'isUrlGenerationSafe']]),
        ];
    }

    public function getUrl($name, $parameters = [], $relative = false)
    {
        if (is_object($parameters)) {
            $parameters = $this->getObjectParameters($name, $parameters);
        }

        return call_user_func([$this->decorated, 'getUrl'], $name, $parameters, $relative);
    }

    public function getPath($name, $parameters = [], $relative = false)
    {
        if (is_object($parameters)) {
            $parameters = $this->getObjectParameters($name, $parameters);
        }

        return call_user_func([$this->decorated, 'getPath'], $name, $parameters, $relative);
    }

    private function getObjectParameters($name, $object)
    {
        $parameters = [];

        $route = $this->router
            ->getRouteCollection()
            ->get($name);

        if (null !== $route) {
            foreach ($route->compile()->getPathVariables() as $variable) {
                if ($this->accessor->isReadable($object, $variable)) {
                    $parameters[$variable] = $this->accessor->getValue($object, $variable);
                } elseif ($route->hasDefault($variable)) {
                    $parameters[$variable] = $route->getDefault($variable);
                }
            }
        }

        return $parameters;
    }
}
