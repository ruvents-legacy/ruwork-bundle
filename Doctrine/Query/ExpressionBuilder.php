<?php

namespace Ruvents\RuworkBundle\Doctrine\Query;

use Doctrine\ORM\Query\Expr;
use Ruvents\DoctrineBundle\Doctrine\Query\PostgreSQLExpressionBuilderTrait;

class ExpressionBuilder extends Expr
{
    use PostgreSQLExpressionBuilderTrait;

    /**
     * @var self
     */
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance(): ExpressionBuilder
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
