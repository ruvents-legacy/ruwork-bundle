<?php

namespace Ruwork\CoreBundle\Mailer;

interface MessageFactoryInterface
{
    /**
     * @return MessageBuilder
     */
    public function createMessageBuilder();
}
