<?php
/**
 * Copyright © Nguyen Huu The <thenguyen.dev@gmail.com>.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Similik\Module\Cms\Services\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use function Similik\dispatch_event;
use Similik\Module\Graphql\Services\KeyValuePairFieldType;
use Similik\Services\Di\Container;
use Similik\Services\Http\Request;
use Similik\Services\Routing\Router;


class WidgetType extends ObjectType
{
    public function __construct(Container $container)
    {
        $config = [
            'name' => 'CMSWidget',
            'fields' => function() use ($container) {
                $fields = [
                    'cms_widget_id' => [
                        'type' => Type::nonNull(Type::id())
                    ],
                    'name' => [
                        'type' => Type::string()
                    ],
                    'status' => [
                        'type' => Type::nonNull(Type::int())
                    ],
                    'setting' => [
                        'type' => Type::listOf($container->get(KeyValuePairFieldType::class)),
                        'resolve' => function($widget, $args, Container $container, ResolveInfo $info) {
                            return isset($widget['setting']) ? json_decode($widget['setting'], true) :  [];
                        }
                    ],
                    'displaySetting' => [
                        'type' => Type::listOf($container->get(KeyValuePairFieldType::class)),
                        'resolve' => function($widget, $args, Container $container, ResolveInfo $info) {
                            return isset($widget['display_setting']) ? json_decode($widget['display_setting'], true) :  [];
                        }
                    ],
                    'sort_order' => [
                        'type' => Type::int()
                    ],
                    'editUrl' => [
                        'type' => Type::string(),
                        'resolve' => function($widget, $args, Container $container, ResolveInfo $info) {
                            if($container->get(Request::class)->isAdmin() == false)
                                return null;
                            return $container->get(Router::class)->generateUrl('widget.grid', ["type"=>$widget['type']], ['id'=> $widget['cms_widget_id']]);
                        }
                    ]
                ];

                dispatch_event('filter.cmsWidget.type', [&$fields]);

                return $fields;
            },
            'resolveField' => function($value, $args, Container $container, ResolveInfo $info) {
                return isset($value[$info->fieldName]) ? $value[$info->fieldName] : null;
            }
        ];
        parent::__construct($config);
    }
}