<?php

namespace Ruvents\RuworkBundle\Doctrine\EntityTrait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait OrderTrait
{
    /**
     * @ORM\Column(type="smallint", name="_order")
     *
     * @Assert\NotBlank()
     * @Assert\Type("int")
     *
     * @var int
     */
    public $order = 0;
}
