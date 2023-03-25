<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Interfaces;

/**
 * DiscountModulesInterface class
 *
 * @package Core\Interfaces
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
interface DiscountModulesInterface {

    /**
     * Install
     *
     */
    public static function install(array $module): void;

    /**
     * Uninstall
     *
     */
    public static function uninstall(array $module): void;
}
