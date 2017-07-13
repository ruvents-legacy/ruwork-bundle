<?php

namespace Ruvents\RuworkBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Condition extends Constraint
{
    /**
     * @var string
     */
    public $expression;

    /**
     * @var array
     */
    public $true = [];

    /**
     * @var array
     */
    public $false = [];

    /**
     * {@inheritdoc}
     */
    public function getDefaultOption()
    {
        return 'expression';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequiredOptions()
    {
        return [
            'expression',
        ];
    }
}
