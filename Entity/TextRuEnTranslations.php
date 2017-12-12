<?php

namespace Ruvents\RuworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ruvents\DoctrineBundle\Translations\AbstractTranslations;

/**
 * @ORM\Embeddable()
 */
class TextRuEnTranslations extends AbstractTranslations
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $ru;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $en;

    public function __construct(string $ru = null, string $en = null)
    {
        $this->ru = $ru;
        $this->en = $en;
    }

    public function __toString()
    {
        return (string) $this->getCurrent();
    }

    public function getRu(): ?string
    {
        return $this->ru;
    }

    public function setRu(?string $ru)
    {
        $this->ru = $ru;

        return $this;
    }

    public function getEn(): ?string
    {
        return $this->en;
    }

    public function setEn(?string $en)
    {
        $this->en = $en;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultCurrentLocale(): string
    {
        return 'ru';
    }

    /**
     * {@inheritdoc}
     */
    protected function getFallbackLocales(): array
    {
        return [
            'ru',
            'en',
        ];
    }
}
