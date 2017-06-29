<?php

namespace Ruwork\CoreBundle\Mailer;

use Twig\Environment;

class MessageBuilder implements MessageBuilderInterface
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var MailUserInterface
     */
    private $from;

    /**
     * @var string[]
     */
    private $subjects = [];

    /**
     * @var string[]
     */
    private $templates = [];

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * @var \Swift_Mime_SimpleMimeEntity[]
     */
    private $attachments = [];

    public function __construct(Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function setFrom($from): MessageBuilderInterface
    {
        if (is_string($from)) {
            $from = $this->mailer->getFrom($from);
        } elseif (!$from instanceof MailUserInterface) {
            throw new \InvalidArgumentException(
                sprintf('Argument $from must be a string or an instance of %s', MailUserInterface::class)
            );
        }

        $this->from = $from;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubjects(array $subjects): MessageBuilderInterface
    {
        $this->subjects = $subjects;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addSubject(string $subject, string $locale = null): MessageBuilderInterface
    {
        if (null === $locale) {
            array_unshift($this->subjects, $subject);
        } else {
            $this->subjects[$locale] = $subject;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplates(array $templates): MessageBuilderInterface
    {
        $this->templates = $templates;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTemplate(string $template, string $locale = null): MessageBuilderInterface
    {
        if (null === $locale) {
            array_unshift($this->templates, $template);
        } else {
            $this->templates[$locale] = $template;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setParameters(array $parameters): MessageBuilderInterface
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addParameter(string $name, $value): MessageBuilderInterface
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setContentType(string $contentType): MessageBuilderInterface
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttachments(array $attachments): MessageBuilderInterface
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAttachment(\Swift_Mime_SimpleMimeEntity $attachment): MessageBuilderInterface
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function buildMessage(MailUserInterface $to): \Swift_Mime_SimpleMessage
    {
        if (null === $this->from) {
            throw new \RuntimeException('Sender (from) is not defined.');
        }

        if ([] === $this->templates) {
            throw new \RuntimeException('Template is not defined.');
        }

        $locale = $to->getMailLocale();

        $subject = isset($this->subjects[$locale]) ? $this->subjects[$locale] : reset($this->subjects);
        $template = isset($this->templates[$locale]) ? $this->templates[$locale] : reset($this->templates);
        $parameters = array_replace($this->parameters, [
            '_message' => [
                'from' => $this->from,
                'to' => $to,
                'subject' => $subject,
                'locale' => $locale,
            ],
        ]);

        $message = (new \Swift_Message())
            ->addFrom($this->from->getEmail(), $this->from->getMailName($locale))
            ->addTo($to->getEmail(), $to->getMailName($locale))
            ->setBody($this->twig->render($template, $parameters))
            ->setContentType($this->contentType);

        if (false !== $subject) {
            $message->setSubject($subject);
        }

        foreach ($this->attachments as $attachment) {
            $message->attach($attachment);
        }

        return $message;
    }

    /**
     * {@inheritdoc}
     */
    public function sendTo(MailUserInterface $to): MessageBuilderInterface
    {
        $message = $this->buildMessage($to);
        $this->mailer->send($message);

        return $this;
    }
}
