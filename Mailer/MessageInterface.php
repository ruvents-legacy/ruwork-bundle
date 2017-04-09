<?php

namespace Ruwork\CoreBundle\Mailer;

interface MessageInterface
{
    /**
     * @return ContactableInterface
     */
    public function getSender();

    /**
     * @return ContactableInterface
     */
    public function getRecipient();

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @return string
     */
    public function getTemplate();

    /**
     * @return array
     */
    public function getTemplateParameters();

    /**
     * @return string
     */
    public function getContentType();
}
