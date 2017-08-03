<?php

namespace Urbanara\OrderSplitterPlugin\Splitter;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
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

    /**
     * @param OrderInterface $order
     *
     * @return array
     */
    function getBuckets(OrderInterface $order): array;

    /**
     * @param ShipmentInterface $newShipment
     * @param OrderInterface $order
     *
     * @return ShipmentInterface
     */
    function setupShipment(ShipmentInterface $newShipment, OrderInterface $order): ShipmentInterface;

    /**
     * @param OrderItemInterface[] $orderItems
     * @param ShipmentInterface $shipmentZero
     * @param ShipmentInterface $newShipment
     */
    function moveUnits($orderItems, ShipmentInterface $shipmentZero, ShipmentInterface $newShipment);
}
