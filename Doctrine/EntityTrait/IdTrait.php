<?php

namespace Ruvents\RuworkBundle\Doctrine\EntityTrait;

use Doctrine\ORM\Mapping as ORM;

trait IdTrait
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue("IDENTITY")
     *
     * @var int
     */
    public $id;
}
