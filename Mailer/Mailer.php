<?php

namespace Ruwork\CoreBundle\Mailer;

class Mailer implements MailerInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $swift;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @param \Swift_Mailer     $swift
     * @param \Twig_Environment $twig
     */
    public function __construct(\Swift_Mailer $swift, \Twig_Environment $twig)
    {
        $this->swift = $swift;
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function send(MessageInterface $message)
    {
        $swiftMessage = new \Swift_Message();

        if (null !== $sender = $message->getSender()) {
            $swiftMessage->setFrom($sender->getContactableAddress(), $sender->getContactableName());
        }

        if (null === $recipient = $message->getRecipient()) {
            throw new \RuntimeException('Message recipient is missing.');
        }

        $swiftMessage->setTo($recipient->getContactableAddress(), $recipient->getContactableName());

        $swiftMessage->setSubject($message->getSubject());

        if (null === $message->getTemplate()) {
            throw new \RuntimeException('Message template is missing.');
        }

        $swiftMessage->setBody(
            $this->twig->render(
                $this->getTemplateName($message),
                array_replace(['message' => $message], $message->getTemplateParameters())
            ),
            $message->getContentType() ?: 'text/html'
        );

        $this->swift->send($swiftMessage);
    }

    /**
     * @param MessageInterface $message
     *
     * @return string
     */
    protected function getTemplateName(MessageInterface $message)
    {
        return str_replace(
            ['%locale%'],
            [$message->getRecipient()->getContactableLocale()],
            $message->getTemplate()
        );
    }
}
