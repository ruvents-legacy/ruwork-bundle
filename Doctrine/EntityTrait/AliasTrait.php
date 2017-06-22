<?php

namespace Ruwork\CoreBundle\Doctrine\EntityTrait;

use Doctrine\ORM\Mapping as ORM;
use Ruwork\CoreBundle\Validator\Constraints\Alias;
use Symfony\Component\Validator\Constraints as Assert;

trait AliasTrait
{
    /**
     * @ORM\Column(type="string", unique=true)
     *
     * @Assert\NotBlank()
     * @Alias()
     *
     * @var string
     */
    public $alias;
}
