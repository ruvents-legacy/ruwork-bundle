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
    public function getMessage(MailUserInterface $to): \Swift_Mime_SimpleMessage
    {
        $locale = $to->getMailLocale();

        $from = $this->from;
        $subject = isset($this->subjects[$locale]) ? $this->subjects[$locale] : reset($this->subjects);
        $template = isset($this->templates[$locale]) ? $this->templates[$locale] : reset($this->templates);
        $parameters = array_replace($this->parameters, [
            '_from' => $from,
            '_to' => $to,
            '_subject' => $subject,
        ]);

        return (new \Swift_Message())
            ->addFrom($from->getEmail(), $from->getMailName($locale))
            ->addTo($to->getEmail(), $to->getMailName($locale))
            ->setSubject($subject)
            ->setBody($this->twig->render($template, $parameters))
            ->setContentType($this->contentType);
    }

    /**
     * {@inheritdoc}
     */
    public function sendTo(MailUserInterface $to): MessageBuilderInterface
    {
        $message = $this->getMessage($to);
        $this->mailer->send($message);

        return $this;
    }
}
