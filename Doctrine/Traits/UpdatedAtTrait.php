<?php

namespace Ruvents\RuworkBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ruvents\DoctrineBundle\Mapping\Timestamp;

trait UpdatedAtTrait
{
    /**
     * @ORM\Column(type="datetime")
     * @Timestamp(on={"persist", "update"})
     *
     * @var \DateTime
     */
    public $updatedAt;
}
