<?php

namespace Urbanara\OrderSplitterPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Urbanara\OrderSplitterPlugin\DependencyInjection\Compiler\SplitterRulesCompilerPass;

final class OrderSplitterPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SplitterRulesCompilerPass());
    }
}
