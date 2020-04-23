<?php
/**
 * Copyright © Nguyen Huu The <the.nguyen@similik.com>.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Similik\Module\Order\Services\Type;


use GraphQL\Type\Definition\InputObjectType;
use function Similik\_mysql;
use function Similik\dispatch_event;
use Similik\Module\Catalog\Services\Type\FilterTool\AttributeFilterType;
use Similik\Module\Graphql\Services\FilterFieldType;
use Similik\Services\Di\Container;

class OrderCollectionFilterType extends InputObjectType
{
    public function __construct(Container $container)
    {
        $config = [
            'name'=> 'OrderCollectionFilter',
            'fields' => function() use($container) {
                $fields = [
                    'id' => $container->get(FilterFieldType::class),
                    'order_number' => $container->get(FilterFieldType::class),
                    'grand_total' => $container->get(FilterFieldType::class),
                    'payment_status' => $container->get(FilterFieldType::class),
                    'shipment_status' => $container->get(FilterFieldType::class),
                    'customer_email' => $container->get(FilterFieldType::class),
                    'created_at' => $container->get(FilterFieldType::class)
                ];

                dispatch_event('filter.orderCollectionFilter.input', [&$fields]);

                return $fields;
            }
        ];
        parent::__construct($config);
    }
}