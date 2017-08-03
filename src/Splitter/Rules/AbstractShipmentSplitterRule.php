<?php

namespace Urbanara\OrderSplitterPlugin\Splitter\Rules;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\Shipment;
use Sylius\Component\Core\Model\ShipmentInterface;
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
    public function applyRule(OrderInterface $order, FactoryInterface $shipmentFactory)
    {
        $orderItemsBuckets = $this->getBuckets($order);
        $shipments = $order->getShipments();
        $shipmentZero = $order->getShipments()->get(0);
        foreach ($orderItemsBuckets as $index => $orderItems) {
            if ($index > 0) {
                /** @var ShipmentInterface $newShipment */
                $newShipment = $shipmentFactory->createNew();
                $newShipment->setOrder($order);
                $this->setupShipment($newShipment, $order);
                $this->moveUnits($orderItems, $shipmentZero, $newShipment);
                $shipments->add($newShipment);
            }
        }
    }

    /**
     * @param OrderInterface $order
     *
     * @return array
     */
    abstract public function getBuckets(OrderInterface $order) : array;

    /**
     * @param OrderItemInterface[] $orderItems
     * @param ShipmentInterface $shipmentZero
     * @param ShipmentInterface $newShipment
     */
    private function moveUnits($orderItems, ShipmentInterface $shipmentZero, ShipmentInterface $newShipment)
    {
        /** @var OrderItemInterface $item */
        foreach ($orderItems as $item) {
            foreach ($item->getUnits() as $unit) {
                /** @var Shipment $shipmentZero */
                $shipmentZero->removeUnit($unit);
                $newShipment->addUnit($unit);
            }
        }
    }

    /**
     * @param ShipmentInterface $newShipment
     * @param OrderInterface $order
     *
     * @return ShipmentInterface
     */
    private function setupShipment(ShipmentInterface $newShipment, OrderInterface $order) : ShipmentInterface
    {
        $shipmentZero = $order->getShipments()->get(static::SHIPMENT_ZERO);
        $newShipment->setMethod($shipmentZero->getMethod());

        return $newShipment;
    }
}
