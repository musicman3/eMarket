<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Settings,
    Modules,
    Valid
};
use Cruder\Db;
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

    public static $jstructure = FALSE;
    public static $js_modules_handler = FALSE;
    public static $page_not_found = FALSE;
    public static $array_pos_value = 'false';

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
        $this->jsHandler();
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
        $R2D2 = new R2D2();
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
     * Template routing for catalog
     *
     * @return string|bool (view routing)
     */
    public static function template(): string|bool {
        $R2D2 = new R2D2();
        return $R2D2->page();
    }

    /**
     * JS Handler routing
     *
     */
    private function jsHandler(): void {
        $R2D2 = new R2D2();
        self::$jstructure = $R2D2->js();
    }

    /**
     * Modules routing
     *
     * @param string $path (path marker controller/view)
     * @return string (modules routing)
     */
    public static function modules(string $path): string {

        if (Valid::inGET('module_path')) {
            return Modules::modulesPath() . '/' . $path . '/' . Settings::path() . '/' . Valid::inGET('module_path');
        } else {
            return Modules::modulesPath() . '/' . $path . '/' . Settings::path();
        }
    }

    /**
     * Template Layers Positioning Controller
     *
     * @param string $position (position)
     * @param string $count (counter marker)
     * @return int|array|string (positions for paths)
     */
    public static function tlpc(string $position, ?string $count = null): int|string|array {

        $page = self::routingPath();

        if (self::$array_pos_value == 'false') {
            self::$array_pos_value = Db::connect()
                    ->read(TABLE_TEMPLATE_CONSTRUCTOR)
                    ->selectIndex('url, value')
                    ->where('group_id=', Settings::path())
                    ->and('page=', $page)
                    ->and('template_name=', Settings::template())
                    ->orderByAsc('sort')
                    ->save();
        }

        if (count(self::$array_pos_value) > 0) {
            $array_out = [];
            foreach (self::$array_pos_value as $val) {
                if ($val[1] == $position) {
                    $array_out[] = str_replace('controller', 'view/' . Settings::template(), $val[0]);
                }
            }
            if ($count == 'count') {
                return count($array_out);
            }
            return $array_out;
        } else {

            $array_pos = Db::connect()
                    ->read(TABLE_TEMPLATE_CONSTRUCTOR)
                    ->selectIndex('url, page')
                    ->where('group_id=', Settings::path())
                    ->and('value=', $position)
                    ->and('template_name=', Settings::template())
                    ->orderByAsc('sort')
                    ->save();

            $array_out = [];
            foreach ($array_pos as $val) {
                if ($val[1] == 'all') {
                    $array_out[] = str_replace('controller', 'view/' . Settings::template(), $val[0]);
                }
            }
            if ($count == 'count') {
                return count($array_out);
            }
            return $array_out;
        }
    }

    /**
     * JS Modules Handler routing
     *
     * @param string $js_path Path to js.php
     */
    public static function jsModulesHandler(?string $js_path = null): void {

        if (Settings::path() == 'admin') {
            $path = self::modules('js/structure');
            if (file_exists($path . '/js.php')) {
                self::$js_modules_handler = $path;
            }
        }

        if (Settings::path() == 'catalog' && $js_path == null) {
            $path = ROOT . '/modules/payment/' . Valid::inPOST('payment_method') . '/js/structure/catalog';
            if (file_exists($path . '/js.php')) {
                self::$js_modules_handler = $path;
            }
        }

        if (Settings::path() == 'catalog' && $js_path != null) {
            $path = ROOT . '/modules/' . $js_path . '/js/structure/catalog';
            if (file_exists($path . '/js.php')) {
                self::$js_modules_handler = $path;
            }
        }
    }

    /**
     * Save page object
     *
     */
    public function savePage(object $eMarket): void {
        self::$emarket = $eMarket;
    }
}
