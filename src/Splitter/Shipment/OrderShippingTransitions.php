<?php

namespace Urbanara\OrderSplitterPlugin\Splitter\Shipment;

final class OrderShippingTransitions
{
    const GRAPH = 'sylius_order_shipping';
    const TRANSITION_REQUEST_SHIPPING = 'request_shipping';
    const TRANSITION_PARTIALLY_SHIP = 'partially_ship';
    const TRANSITION_SPLIT = 'split';
    const TRANSITION_MANUAL_SPLIT = 'manual_split';
    const TRANSITION_SHIP = 'ship';
    const TRANSITION_CANCEL = 'cancel';
}
