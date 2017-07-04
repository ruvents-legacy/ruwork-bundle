<?php

namespace Ruvents\RuworkBundle\Mailer;

class MailUser implements MailUserInterface
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string[]
     */
    private $names;

    /**
     * @var string
     */
    private $locale;

    /**
     * @param string|string[] $name
     */
    public function __construct($email, $name, $locale)
    {
        $this->email = $email;
        $this->names = (array)$name;
        $this->locale = $locale;
    }

    public function __toString(): string
    {
        $name = reset($this->names);

        return (string)$name;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getMailName(string $locale): string
    {
        $name = $this->names[$locale] ?? reset($this->names);

        return $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getMailLocale(): string
    {
        return $this->locale;
    }
}
