<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use R2D2\R2D2;

/**
 * Routing class
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class Routing {

    /**
     * @var object|bool $emarket (The current object of the loaded page)
     */
    public static $emarket = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->route();
    }

    /**
     * Route
     *
     */
    private function route(): void {
        $eMarketPage = $this->init();
        $eMarket = new $eMarketPage();
        $this->savePage($eMarket);
    }

    /**
     * Init
     *
     * @return string|null url
     */
    private function init(): ?string {
        $config = [
            'engine' =>
            [
                'admin' => [
                    'branch' => '/admin',
                    'constructor' => '/view/default/admin/constructor.php',
                    'pagesPath' => '/view/default/admin/pages',
                    'jsPath' => '/js/structure/admin/pages',
                    'modelPath' => '/model/eMarket/Admin',
                    'namespace' => '\eMarket\Admin',
                    'index_route' => 'dashboard',
                ],
                'catalog' => [
                    'branch' => '/',
                    'constructor' => '/view/default/catalog/constructor.php',
                    'pagesPath' => '/view/default/catalog/pages',
                    'jsPath' => '/js/structure/catalog/pages',
                    'modelPath' => '/model/eMarket/Catalog',
                    'namespace' => '\eMarket\Catalog',
                    'index_route' => 'catalog',
                ],
                'install' => [
                    'branch' => '/install',
                    'constructor' => '/view/default/install/constructor.php',
                    'pagesPath' => '/view/default/install/pages',
                    'jsPath' => '/js/structure/install/pages',
                    'modelPath' => '/model/eMarket/Install',
                    'namespace' => '\eMarket\Install',
                    'index_route' => 'index',
                ],
                'uploads' => [
                    'branch' => '/uploads',
                    'constructor' => '',
                    'pagesPath' => '',
                    'jsPath' => '',
                    'modelPath' => '/model/eMarket/Uploads',
                    'namespace' => '\eMarket\Uploads',
                    'index_route' => '',
                ],
                'JsonRpc' => [
                    'branch' => '/services/jsonrpc/request',
                    'constructor' => '',
                    'pagesPath' => '',
                    'jsPath' => '',
                    'modelPath' => '/model/eMarket/JsonRpc',
                    'namespace' => '\eMarket\JsonRpc',
                    'index_route' => 'JsonRpcController',
                ],
            ]
        ];
        $R2D2 = new R2D2();
        $R2D2->config($config);
        return $R2D2->namespace();
    }

    /**
     * Constructor routing
     *
     * @return string (constructor routing string)
     */
    public function constructor(): string|bool {
        $R2D2 = new R2D2();
        return $R2D2->constructor();
    }

    /**
     * Routing path
     *
     * @return string $page (routing path)
     */
    public static function routingPath(): string {
        $R2D2 = new R2D2();
        return $R2D2->routingParameter();
    }

    /**
     * Page routing
     *
     * @return string|bool (page routing)
     */
    public static function page(): string|bool {
        $R2D2 = new R2D2();
        return $R2D2->page();
    }

    /**
     * JS routing
     *
     * @return string|bool (js routing)
     */
    public static function js(): string|bool {
        $R2D2 = new R2D2();
        return $R2D2->js();
    }

    /**
     * Save page object
     *
     */
    public function savePage(object $eMarket): void {
        self::$emarket = $eMarket;
    }
}
