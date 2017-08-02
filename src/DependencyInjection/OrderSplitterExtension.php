<?php

namespace Urbanara\OrderSplitterPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class OrderSplitterExtension extends Extension
{
//    /**
//     * {@inheritdoc}
//     */
//    public function load(array $config, ContainerBuilder $container)
//    {
//        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
//        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
//    }

    /**
     * {@inheritdoc}
     */
    public function load( array $configs, ContainerBuilder $container )
    {
        /*
         urbanara_order_splitter:
            split_by_total:
                DE: 10000
                CH: 100000
         */
        // The next 2 lines are pretty common to all Extension templates.
        $configuration = new Configuration();
        $processedConfig = $this->processConfiguration( $configuration, $configs );

        // This is the KEY TO YOUR ANSWER
        $container->setParameter( 'urbanara_order_splitter.split_by_total', $processedConfig[ 'split_by_total' ]);

        // Other stuff like loading services.yml
    }
}
