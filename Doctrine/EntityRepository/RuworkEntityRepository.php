<?php

namespace Ruvents\RuworkBundle\Doctrine\EntityRepository;

use Doctrine\ORM\EntityRepository;
use Ruvents\RuworkBundle\Doctrine\Query\ExpressionBuilder;

class RuworkEntityRepository extends EntityRepository
{
    public function expr(): ExpressionBuilder
    {
        return ExpressionBuilder::getInstance();
    }
}
