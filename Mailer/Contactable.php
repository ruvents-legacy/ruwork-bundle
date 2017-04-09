<?php

namespace Ruwork\CoreBundle\Mailer;

class Contactable implements ContactableInterface
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var null|string
     */
    private $name;

    /**
     * @var null|string
     */
    private $locale;

    /**
     * @param string      $address
     * @param null|string $name
     * @param null|string $locale
     */
    public function __construct($address, $name = null, $locale = null)
    {
        $this->address = $address;
        $this->name = $name;
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getContactableAddress()
    {
        return $this->address;
    }

    /**
     * {@inheritdoc}
     */
    public function getContactableName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getContactableLocale()
    {
        return $this->locale;
    }
}
