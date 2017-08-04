<?php

namespace Ruvents\RuworkBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait PriorityTrait
{
    /**
     * @ORM\Column(type="float")
     *
     * @Assert\NotBlank()
     * @Assert\Type("numeric")
     *
     * @var int|float
     */
    public $priority = 0;
}
