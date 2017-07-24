# Urbanara Oder Splitter Plugin

Plugin provides basic functionality of order splitting based on splitting criteria and rules on a top of [Sylius platform](https://github.com/Sylius/Sylius)

## Installation

1. Add plugin to your vendors:

```bash
$ composer require urbanara/order-splitter-plugin
```

2. Extend config files:

    1. Import project config: 
    
        ```yml
        # app/config/config.yml

        imports:
            ...
            - { resource: "@UrbanaraOrderSplitterPlugin/Resources/config/config.yml" }
        ```

    2. Add plugin to AppKernel: 
    
        ```php
        // app/AppKernel.php

        $bundles = [
           ...
            new \Urbanara\OrderSplitter\UrbanaraOrderSplitterPlugin(),
        ];

        ```

## Usage

Plugin provides basic functionality for order splitting.

Orders are checked for elegibility to be splitted, based on rules and the action is splitting the shippings.

All features are described in `features/` section. 
