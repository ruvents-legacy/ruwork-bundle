<?php

namespace Ruvents\RuworkBundle\ControllerExtra\Traits;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

trait EntityManagerTrait
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @required
     * @internal
     */
    final public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function getRepository(string $class): EntityRepository
    {
        return $this->entityManager->getRepository($class);
    }
}
