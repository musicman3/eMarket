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
        $this->js();
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
     * @return string|bool (js routing)
     */
    public static function js(): string|bool {
        $R2D2 = new R2D2();
        return $R2D2->js();
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
     * Save page object
     *
     */
    public function savePage(object $eMarket): void {
        self::$emarket = $eMarket;
    }
}
