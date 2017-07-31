<?php

namespace Ruvents\RuworkBundle;

use Ruvents\RuworkBundle\DependencyInjection\Compiler\TwigAppVariablePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RuventsRuworkBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TwigAppVariablePass());
    }
}
