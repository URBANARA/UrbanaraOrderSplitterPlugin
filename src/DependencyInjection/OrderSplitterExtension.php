<?php

namespace Urbanara\OrderSplitterPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class OrderSplitterExtension extends Extension
{

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'order_splitter';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('state_machine.yml');
        $loader->load('services.yml');
    }
}
