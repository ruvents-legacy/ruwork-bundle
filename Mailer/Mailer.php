<?php

namespace Ruwork\CoreBundle\Mailer;

use Symfony\Component\Translation\TranslatorInterface;

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
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var string
     */
    private $translationDomain;

    public function __construct(\Swift_Mailer $swift, \Twig_Environment $twig, TranslatorInterface $translator = null)
    {
        $this->swift = $swift;
        $this->twig = $twig;
        $this->translator = $translator;
    }

    /**
     * @param string $translationDomain
     */
    public function setTranslationDomain($translationDomain)
    {
        $this->translationDomain = $translationDomain;
    }

    /**
     * {@inheritdoc}
     */
    public function send(MessageInterface $message)
    {
        $swiftMessage = new \Swift_Message();

        // sender
        if (null !== $sender = $message->getSender()) {
            $swiftMessage->setFrom($sender->getContactableAddress(), $sender->getContactableName());
        }

        // receiver
        if (null === $recipient = $message->getRecipient()) {
            throw new \RuntimeException('Message recipient is missing.');
        }

        $swiftMessage->setTo($recipient->getContactableAddress(), $recipient->getContactableName());

        // subject
        $swiftMessage->setSubject($this->getSubject($message));

        // body
        if (null === $message->getTemplate()) {
            throw new \RuntimeException('Message template is missing.');
        }

        $swiftMessage->setBody($this->getBody($message), $message->getContentType() ?: 'text/html');

        $this->swift->send($swiftMessage);
    }

    /**
     * @param MessageInterface $message
     *
     * @return string
     */
    protected function getSubject(MessageInterface $message)
    {
        if ($this->translator && $locale = $message->getRecipient()->getContactableLocale()) {
            return $this->translator->trans($message->getSubject(), [], $this->translationDomain, $locale);
        }

        return $message->getSubject();
    }

    /**
     * @param MessageInterface $message
     *
     * @return string
     */
    protected function getBody(MessageInterface $message)
    {
        return $this->twig->render(
            $this->getTemplateName($message),
            array_replace(['_message' => $message], $message->getTemplateParameters())
        );
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
