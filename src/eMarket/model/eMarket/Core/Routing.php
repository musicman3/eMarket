<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Settings
};
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
    public static $eMarket = FALSE;

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
                    'constructor' => '/view/' . Settings::template() . '/admin/constructor.php',
                    'pagesPath' => '/view/default/admin/pages',
                    'jsPath' => '/js/structure/admin/pages',
                    'modelPath' => '/model/eMarket/Admin',
                    'namespace' => '\eMarket\Admin',
                    'index_route' => 'dashboard',
                ],
                'catalog' => [
                    'branch' => '/',
                    'constructor' => '/view/' . Settings::template() . '/catalog/constructor.php',
                    'pagesPath' => '/view/default/catalog/pages',
                    'jsPath' => '/js/structure/catalog/pages',
                    'modelPath' => '/model/eMarket/Catalog',
                    'namespace' => '\eMarket\Catalog',
                    'index_route' => 'catalog',
                ],
                'install' => [
                    'branch' => '/install',
                    'constructor' => '/view/' . Settings::template() . '/install/constructor.php',
                    'pagesPath' => '/view/default/install/pages',
                    'jsPath' => '/js/structure/install/pages',
                    'modelPath' => '/model/eMarket/Install',
                    'namespace' => '\eMarket\Install',
                    'index_route' => 'index',
                ],
                'uploads' => [
                    'branch' => '/uploads/temp',
                    'constructor' => '',
                    'pagesPath' => '',
                    'jsPath' => '',
                    'modelPath' => '/model/eMarket/Uploads',
                    'namespace' => '\eMarket\Uploads',
                    'index_route' => 'index',
                ],
                'JsonRpc' => [
                    'branch' => '/services/jsonrpc/request',
                    'constructor' => '',
                    'pagesPath' => '',
                    'jsPath' => '',
                    'modelPath' => '/model/eMarket/JsonRpc',
                    'namespace' => '\eMarket\JsonRpc',
                    'index_route' => 'JsonRpcController',
                ]
            ]
        ];

        $R2D2 = new R2D2();
        $R2D2->config($config);
        return $R2D2->namespace();
    }

    /**
     * Constructor routing
     *
     * @return string (path to constructor file)
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
     * @return string|bool (path to page file)
     */
    public static function page(): string|bool {
        $R2D2 = new R2D2();
        return $R2D2->page();
    }

    /**
     * Index route
     *
     * @return string|null|bool Index file name
     */
    public static function indexRoute(): string|bool {
        $R2D2 = new R2D2();
        return $R2D2->indexRoute();
    }

    /**
     * JS routing
     *
     * @return string|bool (path to js file)
     */
    public static function js(): string|bool {
        $R2D2 = new R2D2();
        return $R2D2->js();
    }

    /**
     * Save page object
     *
     * @param object $eMarket Page Object
     */
    public function savePage(object $eMarket): void {
        self::$eMarket = $eMarket;
    }
}
