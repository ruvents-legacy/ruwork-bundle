<?php

namespace Ruwork\CoreBundle\Mailer;

use Symfony\Component\Translation\TranslatorInterface;

class MessageFactory implements MessageFactoryInterface
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
    public function createMessageBuilder()
    {
        return new MessageBuilder($this->twig, $this->translator, $this->translationDomain);
    }
}
