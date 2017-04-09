<?php

namespace Ruwork\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller
{
    /**
     * @return \Doctrine\ORM\EntityManager
     * @throws \LogicException
     */
    public function getEntityManager()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->get('doctrine.orm.default_entity_manager');
    }

    /**
     * @return \Swift_Mailer
     * @throws \LogicException
     */
    public function getMailer()
    {
        if (!$this->container->has('mailer')) {
            throw new \LogicException('The SwiftMailerBundle is not registered in your application.');
        }

        return $this->get('mailer');
    }
}
