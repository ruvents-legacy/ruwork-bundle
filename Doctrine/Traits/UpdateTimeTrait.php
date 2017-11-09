<?php

namespace Ruvents\RuworkBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ruvents\DoctrineBundle\Annotations\Mapping\UpdateTimestamp;

trait UpdateTimeTrait
{
    /**
     * @ORM\Column(type="datetimetz_immutable")
     *
     * @UpdateTimestamp()
     *
     * @var \DateTimeImmutable
     */
    protected $updateTime;

    public function getUpdateTime(): \DateTimeImmutable
    {
        return $this->updateTime;
    }
}
