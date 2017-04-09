<?php

namespace Ruwork\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\RegexValidator;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Alias extends Regex
{
    const PATTERN = '#^[a-z0-9-]+$#';
    const HTML_PATTERN = '^[a-z0-9-]+$';
    const ROUTE_REQUIREMENT = '[a-z0-9-]+';
    const CLEAN_PATTERN = '#[^a-z0-9-]+#';

    /**
     * @var string
     */
    public $pattern = self::PATTERN;

    /**
     * {@inheritdoc}
     */
    public function getRequiredOptions()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return RegexValidator::class;
    }
}
