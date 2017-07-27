<?php

namespace Urbanara\OrderSplitterPlugin\Splitter\Rules;

use Sylius\Component\Core\Model\OrderInterface;
use Urbanara\OrderSplitterPlugin\Splitter\SplitRuleInterface;

class FiftyFiftyRule extends AbstractShipmentSplitterRule implements SplitRuleInterface
{

    /**
     * @param OrderInterface $order
     *
     * @return bool
     */
    public function match(OrderInterface $order): bool
    {
        if ($order->getItemUnits()->count() > 2) {
            return true;
        }
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
            $bucketIndex = $index % 2 === 0 ? 0 : 1;
            $buckets[$bucketIndex][] = $orderItem;
        }

        return $buckets;
    }
}
