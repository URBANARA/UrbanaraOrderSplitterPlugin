<?php

namespace Urbanara\OrderSplitterPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SplitterRulesCompilerPass implements CompilerPassInterface
{
    const ORDER_SPLITTER_RULE_TAG = 'urbanara.order_splitter_plugin.rule';
    const ORDER_SPLITTER_MANAGER_SERVICE_ID = 'urbanara.order_splitter.manager';

    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition(self::ORDER_SPLITTER_MANAGER_SERVICE_ID)) {
            return;
        }

        $definition = $container->getDefinition(self::ORDER_SPLITTER_MANAGER_SERVICE_ID);

        foreach ($container->findTaggedServiceIds(self::ORDER_SPLITTER_RULE_TAG) as $id => $attributes) {
            $definition->addMethodCall('appendRule', array(new Reference($id)));
        }
    }
}
