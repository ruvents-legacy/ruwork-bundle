<?php

namespace Ruvents\RuworkBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ruvents\DoctrineBundle\Mapping\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

trait TranslatableTitleTrait
{
    /**
     * @Translatable("title%Locale%")
     *
     * @var string
     */
    public $title;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     *
     * @var string
     */
    public $titleRu;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     *
     * @var string
     */
    public $titleEn;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->title;
    }
}
