<?php

namespace Ruwork\CoreBundle\Mailer;

use Symfony\Component\Translation\TranslatorInterface;
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
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var MailUserInterface[]
     */
    private $from;

    public function __construct(
        Environment $twig,
        \Swift_Mailer $swift,
        TranslatorInterface $translator,
        array $from = []
    ) {
        $this->twig = $twig;
        $this->swift = $swift;
        $this->translator = $translator;
        $this->from = array_map(function (array $config) {
            return new MailUser($config['email'], $config['name'], $config['locale']);
        }, $from);
    }

    /**
     * @param string|MailUserInterface|null $from
     */
    public function buildMessage(
        $from = null,
        string $subject = null,
        string $template = null,
        array $parameters = []
    ): MessageBuilderInterface {
        $builder = new MessageBuilder($this->swift, $this->twig);

        if (null !== $from) {
            if (is_string($from)) {
                if (!isset($this->from[$from])) {
                    throw new \OutOfBoundsException(sprintf('Sender "%s" is not registered.', $from));
                }

                $from = $this->from[$from];
            }

            $builder->setFrom($from);
        }

        if (null !== $subject) {
            $builder->addSubject($subject);
        }

        if (null !== $template) {
            $builder->addTemplate($template);
        }

        if (null !== $parameters) {
            $builder->setParameters($parameters);
        }

        return $builder;
    }

    public function send(\Swift_Mime_SimpleMessage $message)
    {
        $this->swift->send($message);
    }
}
