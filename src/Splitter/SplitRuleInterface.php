<?php

namespace Urbanara\OrderSplitterPlugin\Splitter;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;

interface SplitRuleInterface
{
    /**
     * @param OrderInterface $order
     *
     * @return bool
     */
    public function match(OrderInterface $order): bool;

    /**
     * @param OrderInterface $order
     *
     * @return array
     */
    public function getBuckets(OrderInterface $order): array;

    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @param ShipmentInterface $newShipment
     * @param OrderInterface $order
     *
     * @return ShipmentInterface
     */
    public function setupShipment(ShipmentInterface $newShipment, OrderInterface $order): ShipmentInterface;

    /**
     * @param $orderItems
     * @param ShipmentInterface $shipmentZero
     * @param ShipmentInterface $newShipment
     *
     * @return mixed
     */
    public function moveUnits($orderItems, ShipmentInterface $shipmentZero, ShipmentInterface $newShipment);
}
