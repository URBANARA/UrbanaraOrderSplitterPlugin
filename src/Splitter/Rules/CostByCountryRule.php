<?php

namespace Urbanara\OrderSplitterPlugin\Splitter\Rules;

use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\DependencyInjection\Container;
use Urbanara\OrderSplitterPlugin\Splitter\SplitRuleInterface;

class CostByCountryRule extends AbstractShipmentSplitterRule implements SplitRuleInterface
{
    const RULE_NAME = 'CostByCountryRule';

    /** @var Container */
    private $container;

    /** @var mixed */
    private $config;

    /** @var mixed */
    private $logger;

    /**
     * @param Container $container
     * @param LoggerInterface $logger
     */
    public function __construct(Container $container, LoggerInterface $logger)
    {
        $this->container = $container;
        $this->logger = $logger;
        $this->config = $this->container->getParameter( 'order_splitter.split_by_total');
    }


    /**
     * @param OrderInterface $order
     *
     * @return bool
     */
    public function match(OrderInterface $order): bool
    {
        dump($this->config);
        $this->logger->info('[OrderSplitter] (CostByCountryRule) ' . \json_encode($this->config));
        die();
//        if ($order->getItemUnits()->count() > 4) {
//            return true;
//        }
        return false;
    }


    /**
     * @param OrderInterface $order
     *
     * @return array
     */
    public function getBuckets(OrderInterface $order) : array
    {
        $orderItems = $order->getItems();

        $buckets = [];

        foreach ($orderItems as $index => $orderItem) {
            $bucketIndex = $index % 4 === 0 ? 0 : 1;
            $buckets[$bucketIndex][] = $orderItem;
        }

        return $buckets;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return self::RULE_NAME;
    }
}
