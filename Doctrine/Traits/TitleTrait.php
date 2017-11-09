<?php

namespace Ruvents\RuworkBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait TitleTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Length(max=255)
     *
     * @var string
     */
    protected $title = '';

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
