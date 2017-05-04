<?php

namespace Ruwork\CoreBundle\Doctrine\EntityTrait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait NameIdTrait
{
    /**
     * @ORM\Column(type="string", length=50)
     * @ORM\Id()
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     * @Assert\Regex("/^[0-9a-z_]+$/")
     *
     * @var string
     */
    public $name;
}
