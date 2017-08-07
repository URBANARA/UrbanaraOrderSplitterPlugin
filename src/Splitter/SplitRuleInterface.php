<?php

namespace Urbanara\OrderSplitterPlugin\Splitter;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface SplitRuleInterface
{
    /**
     * @param OrderInterface $order
     *
     * @return bool
     */
    public function match(OrderInterface $order): bool;

    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @param OrderInterface $order
     * @param FactoryInterface $shipmentFactory
     */
    public function applyRule(OrderInterface $order, FactoryInterface $shipmentFactory);
}
