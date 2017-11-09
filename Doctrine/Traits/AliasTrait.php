<?php

namespace Ruvents\RuworkBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ruvents\RuworkBundle\Validator\Constraints\Alias;
use Symfony\Component\Validator\Constraints as Assert;

trait AliasTrait
{
    /**
     * @ORM\Column(type="string", unique=true)
     *
     * @Assert\NotBlank()
     * @Alias()
     *
     * @var string
     */
    protected $alias = '';

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias)
    {
        $this->alias = $alias;

        return $this;
    }
}
