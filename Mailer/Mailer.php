<?php

namespace Ruvents\RuworkBundle\Mailer;

use Twig\Environment;

class Mailer
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var \Swift_Mailer
     */
    private $swift;

    /**
     * @var MailUserInterface[]
     */
    private $fromUsers;

    public function __construct(Environment $twig, \Swift_Mailer $swift, array $from = [])
    {
        $this->twig = $twig;
        $this->swift = $swift;
        $this->fromUsers = array_map(function (array $config) {
            return new MailUser($config['email'], $config['name'], $config['locale']);
        }, $from);
    }

    public function getFrom($name): MailUserInterface
    {
        if (!isset($this->fromUsers[$name])) {
            throw new \OutOfBoundsException(sprintf('Sender "%s" is not registered.', $name));
        }

        return $this->fromUsers[$name];
    }

    public function createMessageBuilder(): MessageBuilderInterface
    {
        return new MessageBuilder($this, $this->twig);
    }

    public function send(\Swift_Mime_SimpleMessage $message)
    {
        $this->swift->send($message);
    }
}
