<?php

namespace Urbanara\OrderSplitterPlugin\Splitter\Rules;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

abstract class AbstractShipmentSplitterRule
{
    const SHIPMENT_ZERO = 0;

    /**
     * @return string
     */
    abstract public function getName() : string;

    /**
     * @param OrderInterface $order
     * @param FactoryInterface $shipmentFactory
     */
    abstract public function applyRule(OrderInterface $order, FactoryInterface $shipmentFactory);

    /**
     * @param OrderInterface $order
     *
     * @return bool
     */
    abstract public function match(OrderInterface $order): bool;
}
