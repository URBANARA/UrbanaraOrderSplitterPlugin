<?php

namespace Urbanara\OrderSplitterPlugin\Splitter\Rules;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\Shipment;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Urbanara\OrderSplitterPlugin\Splitter\SplitRuleInterface;

class TwentyEightyRule extends AbstractShipmentSplitterRule implements SplitRuleInterface
{
    const RULE_NAME = 'TwentyEightyRule';

    /**
     * @param OrderInterface $order
     *
     * @return bool
     */
    public function match(OrderInterface $order): bool
    {
        if ($order->getItemUnits()->count() > 4) {
            return true;
        }
        return false;
    }


    /**
     * @param OrderInterface $order
     *
     * @return array
     */
    private function getBuckets(OrderInterface $order) : array
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
     * @param OrderItemInterface[] $orderItems
     * @param ShipmentInterface $shipmentZero
     * @param ShipmentInterface $newShipment
     */
    protected function moveUnits($orderItems, ShipmentInterface $shipmentZero, ShipmentInterface $newShipment)
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
    protected function setupShipment(ShipmentInterface $newShipment, OrderInterface $order) : ShipmentInterface
    {
        $shipmentZero = $order->getShipments()->get(static::SHIPMENT_ZERO);
        $newShipment->setMethod($shipmentZero->getMethod());

        return $newShipment;
    }
}
