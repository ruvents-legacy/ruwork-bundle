<?php

namespace Ruvents\RuworkBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;

trait VisibleTrait
{
    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    public $visible = true;

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible)
    {
        $this->visible = $visible;

        return $this;
    }
}
