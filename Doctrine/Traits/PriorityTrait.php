<?php

namespace Ruvents\RuworkBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;

trait PriorityTrait
{
    /**
     * @ORM\Column(type="float")
     *
     * @var float
     */
    protected $priority = 0;

    public function getPriority(): float
    {
        return $this->priority;
    }

    public function setPriority(float $priority)
    {
        $this->priority = $priority;

        return $this;
    }
}
