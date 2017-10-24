<?php

namespace Ruvents\RuworkBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ruvents\DoctrineBundle\Annotations\Mapping\UpdateTimestamp;

trait UpdatedAtTrait
{
    /**
     * @ORM\Column(type="datetimetz_immutable")
     *
     * @UpdateTimestamp()
     *
     * @var \DateTimeImmutable
     */
    protected $updatedAt;

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
