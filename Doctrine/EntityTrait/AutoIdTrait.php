<?php

namespace Ruvents\RuworkBundle\Doctrine\EntityTrait;

use Doctrine\ORM\Mapping as ORM;

/**
 * @deprecated Use IdTrait
 */
trait AutoIdTrait
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     *
     * @var int
     */
    public $id;
}
