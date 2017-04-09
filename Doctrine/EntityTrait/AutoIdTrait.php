<?php

namespace Ruwork\CoreBundle\Doctrine\EntityTrait;

use Doctrine\ORM\Mapping as ORM;

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
