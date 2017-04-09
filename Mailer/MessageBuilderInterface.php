<?php

namespace Ruwork\CoreBundle\Mailer;

interface MessageBuilderInterface
{
    /**
     * @param ContactableInterface $sender
     *
     * @return $this
     * @throws \RuntimeException
     */
    public function setSender(ContactableInterface $sender);

    /**
     * @param ContactableInterface $recipient
     *
     * @return $this
     * @throws \RuntimeException
     */
    public function setRecipient(ContactableInterface $recipient);

    /**
     * @param string $subject
     * @param array  $parameters
     *
     * @return $this
     * @throws \RuntimeException
     */
    public function setSubject($subject, array $parameters = []);

    /**
     * @param string $template
     * @param array  $parameters
     * @param string $contentType
     * @param int    $priority
     *
     * @return $this
     * @throws \RuntimeException
     */
    public function addTemplate($template, array $parameters = [], $contentType = 'text/html', $priority = 0);

    /**
     * @return \Swift_Message
     * @throws \RuntimeException
     */
    public function getMessage();
}
