<?php

namespace Ruwork\CoreBundle\Mailer;

class Message implements MessageInterface
{
    /**
     * @var ContactableInterface
     */
    private $sender;

    /**
     * @var ContactableInterface
     */
    private $recipient;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $templateParameters = [];

    /**
     * @var string
     */
    private $contentType;

    /**
     * {@inheritdoc}
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param ContactableInterface $sender
     *
     * @return $this
     */
    public function setSender(ContactableInterface $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param ContactableInterface $recipient
     *
     * @return $this
     */
    public function setRecipient(ContactableInterface $recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string      $template
     * @param array       $parameters
     * @param null|string $contentType
     *
     * @return $this
     */
    public function setTemplate($template, array $parameters = [], $contentType = 'text/html')
    {
        $this->template = $template;
        $this->templateParameters = $parameters;
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateParameters()
    {
        return $this->templateParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType()
    {
        return $this->contentType;
    }
}
