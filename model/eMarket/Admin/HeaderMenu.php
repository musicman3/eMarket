<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

use \eMarket\Core\{
    Settings
};

/**
 * Header Menu
 *
 * @package Admin
 * @author eMarket
 * 
 */
class HeaderMenu {

    public static $menu_market = '0';
    public static $menu_sales = '1';
    public static $menu_marketing = '2';
    public static $menu_customers = '3';
    public static $menu_tools = '4';
    public static $menu_languages = '5';
    public static $menu_help = '6';
    public static $menu_exit = '7';
    public static $level = [];
    public static $menu = [];
    public static $submenu = [];
    public static $param_1 = [];
    public static $param_2 = [];

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->init();
        $this->initModules();
        $this->levelOne();
        $this->staticLevels();
    }

    /**
     * Init
     *
     */
    public function init() {
        $files = glob(ROOT . '/model/eMarket/Admin/*');
        foreach ($files as $filename) {
            $namespace = '\eMarket\Admin\\' . pathinfo($filename, PATHINFO_FILENAME);
            if (method_exists($namespace, 'menu')) {
                $namespace::menu();
            }
        }
    }

    /**
     * Init Modules
     *
     */
    public function initModules() {
        $group = glob(ROOT . '/modules/*');
        $files = [];
        foreach ($group as $group_name) {
            $path = glob($group_name . '/*');
            foreach ($path as $value) {
                array_push($files, $value);
            }
        }
        foreach ($files as $filename) {
            $namespace = '\eMarket\Core\Modules\\' . ucfirst(pathinfo(dirname($filename, 1), PATHINFO_FILENAME)) . '\\' . ucfirst(pathinfo($filename, PATHINFO_FILENAME));
            if (method_exists($namespace, 'menu')) {
                $namespace::menu();
            }
        }
    }

    /**
     * Level One
     *
     */
    public function levelOne() {
        self::$level[self::$menu_market] = ['#', lang('menu_market'), 'true', 'bi-cart4'];
        self::$level[self::$menu_sales] = ['#', lang('menu_sellings'), 'true', 'bi-calculator'];
        self::$level[self::$menu_marketing] = ['#', lang('menu_marketing'), 'true', 'bi-graph-up'];
        self::$level[self::$menu_customers] = ['#', lang('menu_customers'), 'true', 'bi-person-lines-fill'];
        self::$level[self::$menu_tools] = ['#', lang('menu_tools'), 'true', 'bi-tools'];
        self::$level[self::$menu_languages] = ['#', lang('menu_languages'), 'true', 'bi-spellcheck'];
        self::$level[self::$menu_help] = ['#', lang('menu_extra'), 'true', 'bi-lightbulb-fill'];
        self::$level[self::$menu_exit] = ['?route=login&logout=ok', lang('menu_exit'), 'false', 'bi-box-arrow-right'];
    }

    /**
     * Set parameters
     *
     */
    public static function setParameters($param_1, $param_2) {
        self::$param_1 = $param_1;
        self::$param_2 = $param_2;
    }

    /**
     * Get parameters
     *
     * @return array Parameters
     */
    public static function getParameters() {
        return [self::$param_1, self::$param_2];
    }

    /**
     * Get parameters
     *
     */
    public static function clearParameters($flag) {
        if ($flag == 'false') {
            self::$param_1 = '';
            self::$param_2 = '';
        }
    }

    /**
     * Static levels
     *
     */
    public function staticLevels() {

        //LANGUAGES
        for ($lng = 0; $lng < count(lang('#lang_all')); $lng++) {
            self::$menu[self::$menu_languages][$lng] = [Settings::langCurrencyPath() . '&language=' . lang('#lang_all')[$lng], 'bi-caret-right-fill', lang('language_name', lang('#lang_all')[$lng]), '', 'false'];
        }

        //HELP
        self::$menu[self::$menu_help][0] = ['http://emarketforum.com', 'bi-chat-quote', lang('menu_support'), 'target="_blank"', 'false'];
        self::$menu[self::$menu_help][1] = ['/', 'bi-bag', lang('menu_catalog'), 'target="_blank"', 'false'];
    }

}
