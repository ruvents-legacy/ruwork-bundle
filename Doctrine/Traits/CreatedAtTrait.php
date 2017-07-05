<?php

namespace Ruvents\RuworkBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ruvents\DoctrineBundle\Mapping\Timestamp;

trait CreatedAtTrait
{
    /**
     * @ORM\Column(type="datetime")
     * @Timestamp(on={"persist"}, onlyIfNull=true)
     *
     * @var \DateTime
     */
    public $createdAt;
}
