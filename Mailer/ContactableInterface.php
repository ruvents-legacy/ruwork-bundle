<?php

namespace Ruwork\CoreBundle\Mailer;

interface ContactableInterface
{
    /**
     * @return string
     */
    public function getContactableAddress();

    /**
     * @return null|string
     */
    public function getContactableName();

    /**
     * @return null|string
     */
    public function getContactableLocale();
}
