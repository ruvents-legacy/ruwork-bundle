<?php

namespace Ruvents\RuworkBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ruvents\DoctrineBundle\Mapping\Timestamp;

trait UpdatedAtTrait
{
    /**
     * @ORM\Column(type="datetime")
     * @Timestamp(on={Timestamp::ON_PERSIST, Timestamp::ON_UPDATE})
     *
     * @var \DateTime
     */
    public $updatedAt;
}
