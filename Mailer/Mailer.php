<?php

namespace Ruwork\CoreBundle\Mailer;

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

    public function buildMessage(string $from = null): MessageBuilderInterface
    {
        $builder = new MessageBuilder($this->swift, $this->twig);

        if (null !== $from) {
            if (!isset($this->fromUsers[$from])) {
                throw new \OutOfBoundsException(sprintf('Sender "%s" is not registered.', $from));
            }

            $builder->setFrom($this->fromUsers[$from]);
        }

        return $builder;
    }

    public function send(\Swift_Mime_SimpleMessage $message)
    {
        $this->swift->send($message);
    }
}
