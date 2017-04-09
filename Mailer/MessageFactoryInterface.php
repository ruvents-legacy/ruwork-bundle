<?php

namespace Ruwork\CoreBundle\Mailer;

interface MessageFactoryInterface
{
    /**
     * @return MessageBuilderInterface
     */
    public function createMessageBuilder();
}
