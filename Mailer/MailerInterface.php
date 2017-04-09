<?php

namespace Ruwork\CoreBundle\Mailer;

interface MailerInterface
{
    /**
     * @param MessageInterface $message
     */
    public function send(MessageInterface $message);
}
