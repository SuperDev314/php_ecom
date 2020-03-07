<?php
/**
 * Copyright © Nguyen Huu The <thenguyen.dev@gmail.com>.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Similik\Module\Checkout\Middleware\Cart\Add;

use function Similik\get_default_language_Id;
use Similik\Module\Checkout\Services\Cart\Cart;
use Similik\Module\Checkout\Services\Cart\Item;
use Similik\Services\Http\Request;
use Similik\Services\Http\Response;
use Similik\Middleware\MiddlewareAbstract;

class AddProductMiddleware extends MiddlewareAbstract
{
    /**
     * @param Request $request
     * @param Response $response
     * @param null $delegate
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, $delegate = null)
    {
        $promise = $this->getContainer()->get(Cart::class)->addItem(
            $request->request->all()
        );

        $promise->then(function(Item $item) use ($response) {
            $response->addAlert('cart_add_success', 'success', "{$item->getData('product_name')} was added to shopping cart successfully")->notNewPage();
        });

        $promise->otherwise(function($error) use ($response) {
            $response->addAlert('cart_add_error', 'error', $error['message'])->notNewPage();
        });

        return $promise;
    }
}