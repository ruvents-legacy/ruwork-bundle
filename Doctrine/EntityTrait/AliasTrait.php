<?php

namespace Ruvents\RuworkBundle\Doctrine\EntityTrait;

use Doctrine\ORM\Mapping as ORM;
use Ruvents\RuworkBundle\Validator\Constraints\Alias;
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
