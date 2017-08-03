<?php

namespace Urbanara\OrderSplitterPlugin\Splitter;

use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class SplitManager
{
    /**
     * @var SplitRuleInterface[]
     */
    private $rules = [];

    /**
     * @var FactoryInterface
     */
    private $shipmentFactory;


    /**
     * @param FactoryInterface $factory
     * @param LoggerInterface $logger
     */
    public function __construct(FactoryInterface $factory, LoggerInterface $logger)
    {
        $this->shipmentFactory = $factory;
        $this->logger = $logger;
    }

    /**
     * @param SplitRuleInterface $rule
     */
    public function appendRule(SplitRuleInterface $rule)
    {
        $this->logger->info("[OrderSplitter] Append Rules " . $rule->getName());
        $this->rules[] = $rule;
    }

    /**
     * @return SplitRuleInterface[]
     */
    protected function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param OrderInterface $order
     */
    public function executeRules(OrderInterface $order)
    {
        $this->logger->info('[OrderSplitter] ExecuteRules');

        foreach ($this->getRules() as $rule) {
            $this->logger->info('[OrderSplitter] Testing rule' . $rule->getName());
            if ($rule->match($order) === true) {
                $this->logger->info('[OrderSplitter] Matched rule ' . $rule->getName());
                $rule->apply($order, $this->shipmentFactory);
                break;
            }
        }
    }
}
