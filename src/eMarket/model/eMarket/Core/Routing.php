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
     * Save page object
     *
     */
    public function savePage(object $eMarket): void {
        self::$emarket = $eMarket;
    }
}
