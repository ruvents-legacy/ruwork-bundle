<?php

namespace Ruwork\CoreBundle\Mailer;

use Symfony\Component\Translation\TranslatorInterface;

class MessageBuilder implements MessageBuilderInterface
{
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

    /**
     * @var ContactableInterface
     */
    private $sender;

    /**
     * @var ContactableInterface
     */
    private $recipient;

    /**
     * @var array
     */
    private $subject;

    /**
     * @var array
     */
    private $templates;

    /**
     * @var bool
     */
    private $locked = false;

    /**
     * @param \Twig_Environment        $twig
     * @param null|TranslatorInterface $translator
     * @param null|string              $translationDomain
     */
    public function __construct(
        \Twig_Environment $twig,
        TranslatorInterface $translator = null,
        $translationDomain = null
    ) {
        $this->twig = $twig;
        $this->translator = $translator;
        $this->translationDomain = $translationDomain;
    }

    /**
     * {@inheritdoc}
     */
    public function setSender(ContactableInterface $sender)
    {
        if ($this->locked) {
            throw new \RuntimeException('The builder is locked.');
        }

        $this->sender = $sender;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRecipient(ContactableInterface $recipient)
    {
        if ($this->locked) {
            throw new \RuntimeException('The builder is locked.');
        }

        $this->recipient = $recipient;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject($subject, array $parameters = [])
    {
        if ($this->locked) {
            throw new \RuntimeException('The builder is locked.');
        }

        $this->subject = [$subject, $parameters];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTemplate($template, array $parameters = [], $contentType = 'text/html', $priority = 0)
    {
        if ($this->locked) {
            throw new \RuntimeException('The builder is locked.');
        }

        $this->templates[$priority][] = [$template, $parameters, $contentType];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        if ($this->locked) {
            throw new \RuntimeException('The builder is locked.');
        }

        $this->locked = true;

        $message = new \Swift_Message();

        if ($this->sender) {
            $message->addFrom($this->sender->getContactableAddress(), $this->sender->getContactableName());
        }

        if ($this->recipient) {
            $message->addTo($this->recipient->getContactableAddress(), $this->recipient->getContactableName());
        }

        if ($this->subject) {
            if ($this->recipient && $this->translator && false !== $this->translationDomain) {
                $subject = $this->translator->trans(
                    $this->subject[0],
                    $this->subject[1],
                    $this->translationDomain,
                    $this->recipient->getContactableLocale()
                );
            } else {
                $subject = $this->subject[0];
            }

            $message->setSubject($subject);
        }

        if ($this->templates) {
            $templates = $this->templates;
            krsort($templates);

            foreach ($templates as $templatesPriorityGroup) {
                foreach ($templatesPriorityGroup as $template) {
                    try {
                        $body = $this->twig->render(
                            $this->getTemplateName($template[0]),
                            array_replace(['_recipient' => $this->recipient], $template[1])
                        );

                        $message->setBody($body, $template[2]);

                        break(2);
                    } catch (\Twig_Error_Loader $exception) {
                    }
                }
            }
        }

        return $message;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function getTemplateName($name)
    {
        if ($this->recipient) {
            $name = str_replace('%locale%', $this->recipient->getContactableLocale(), $name);
        }

        return $name;
    }
}
