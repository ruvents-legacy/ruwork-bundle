<?php

namespace Ruvents\RuworkBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait PriorityTrait
{
    /**
     * @ORM\Column(type="float")
     *
     * @Assert\NotBlank()
     *
     * @var float
     */
    protected $priority = 0;

    /**
     * @return float
     */
    public function getPriority(): float
    {
        return $this->priority;
    }

    /**
     * @param float $priority
     *
     * @return $this
     */
    public function setPriority(float $priority)
    {
        $this->priority = $priority;

        return $this;
    }
}
