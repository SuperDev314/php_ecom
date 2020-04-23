<?php
/**
 * Copyright © Nguyen Huu The <the.nguyen@similik.com>.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

/** @var \Similik\Services\Routing\Router $router */
$router->addAdminRoute('dashboard', 'GET', '/', [
    \Similik\Module\Cms\Middleware\Dashboard\TitleMiddleware::class,
    \Similik\Module\Cms\Middleware\Dashboard\LayoutMiddleware::class
]);

$router->addAdminRoute('page.grid', 'GET', '/pages', [
    \Similik\Module\Cms\Middleware\Page\Grid\AddNewButtonMiddleware::class,
    \Similik\Module\Cms\Middleware\Page\Grid\GridMiddleware::class
]);

$router->addAdminRoute('page.create', 'GET', '/page/create', [
    \Similik\Module\Cms\Middleware\Page\Edit\InitMiddleware::class,
    \Similik\Module\Cms\Middleware\Page\Edit\FormMiddleware::class
]);

$router->addAdminRoute('page.edit', 'GET', '/page/edit/{id:\d+}', [
    \Similik\Module\Cms\Middleware\Page\Edit\InitMiddleware::class,
    \Similik\Module\Cms\Middleware\Page\Edit\FormMiddleware::class
]);

$router->addAdminRoute('page.delete', 'GET', '/page/delete/{id:\d+}', [
    \Similik\Module\Cms\Middleware\Page\Delete\DeleteMiddleware::class,
]);

$router->addAdminRoute('page.save', 'POST', '/page/save[/{id:\d+}]', [
    \Similik\Module\Cms\Middleware\Page\Edit\InitMiddleware::class,
    \Similik\Module\Cms\Middleware\Page\Edit\FormMiddleware::class
]);

$router->addAdminRoute('widget.grid', 'GET', '/widgets', [
    \Similik\Module\Cms\Middleware\Widget\Grid\GridMiddleware::class,
    \Similik\Module\Cms\Middleware\Widget\Grid\AddNewButtonMiddleware::class
]);

$router->addAdminRoute('widget.create', 'GET', '/widget/create', [
    \Similik\Module\Cms\Middleware\Widget\Edit\EditMiddleware::class
]);

$router->addAdminRoute('widget.edit', 'GET', '/widget/edit/{type}/{id:\d+}', [
    \Similik\Module\Cms\Middleware\Widget\Edit\EditMiddleware::class
]);

$router->addAdminRoute('widget.delete', 'GET', '/widget/edit/{id:\d+}', [
    \Similik\Module\Cms\Middleware\Widget\Delete\DeleteMiddleware::class
]);

$router->addAdminRoute('cms.install', ["POST", "GET"], '/cms/migrate/install', [
    \Similik\Module\Cms\Middleware\Migrate\Install\InstallMiddleware::class
]);

////////////////////////////////////////////
///            SITE ROUTERS           //////
////////////////////////////////////////////

$pageViewMiddleware = [
    \Similik\Module\Cms\Middleware\Page\View\ViewMiddleware::class
];
$router->addSiteRoute('page.view', 'GET', '/page/id/{id:\d+}', $pageViewMiddleware);

// Pretty url
$router->addSiteRoute('page.view.pretty', 'GET', '/page/{slug}', $pageViewMiddleware);

$router->addSiteRoute('homepage', 'GET', '/', [
    \Similik\Module\Cms\Middleware\Page\View\HomepageMiddleware::class
]);