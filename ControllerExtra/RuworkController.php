<?php

namespace Ruvents\RuworkBundle\ControllerExtra;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class RuworkController extends AbstractController
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedServices()
    {
        return array_merge([
            'event_dispatcher' => EventDispatcherInterface::class,
        ], parent::getSubscribedServices());
    }

    protected function dispatch(string $eventName, Event $event = null)
    {
        $this->container->get('event_dispatcher')->dispatch($eventName, $event);
    }
}
