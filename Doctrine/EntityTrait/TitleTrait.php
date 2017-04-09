<?php

namespace Ruwork\CoreBundle\Doctrine\EntityTrait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait TitleTrait
{
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @var string
     */
    public $title;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->title;
    }
}
