<?php

namespace Ruvents\RuworkBundle\Security;

/**
 * @deprecated
 */
final class TokenHelper
{
    private function __construct()
    {
    }

    public static function generate(int $length): string
    {
        @trigger_error(sprintf('%s is deprecated since version 0.5.16, to be removed in 0.6. Use %s instead.', __CLASS__, TokenGenerator::class), E_USER_DEPRECATED);

        return TokenGenerator::generate($length);
    }
}
