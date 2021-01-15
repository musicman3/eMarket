<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

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
    public static $menu_help = '5';
    public static $menu_exit = '6';
    
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
        $this->Init();
        $this->levelOne();
        $this->staticLevels();
    }

    /**
     * Init
     *
     */
    public function Init() {
        $files = glob(ROOT . '/model/eMarket/admin/*');
        foreach ($files as $filename) {
            $namespace = '\eMarket\Admin\\' . pathinfo($filename, PATHINFO_FILENAME);
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
        self::$level[self::$menu_market] = ['#', lang('menu_market'), 'true'];
        self::$level[self::$menu_sales] = ['#', lang('menu_sellings'), 'true'];
        self::$level[self::$menu_marketing] = ['#', lang('menu_marketing'), 'true'];
        self::$level[self::$menu_customers] = ['#', lang('menu_customers'), 'true'];
        self::$level[self::$menu_tools] = ['#', lang('menu_tools'), 'true'];
        self::$level[self::$menu_help] = ['#', lang('menu_extra'), 'true'];
        self::$level[self::$menu_exit] = ['?route=login&logout=ok', lang('menu_exit'), 'false'];
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
        //HELP
        self::$level[self::$menu_help] = ['#', lang('menu_extra'), 'true'];

        //SUPPORT
        self::$menu[self::$menu_help][0] = ['#', 'glyphicon glyphicon-equalizer', lang('menu_help'), '', 'true'];
        self::$submenu[self::$menu_help][0][0] = ['http://emarketforum.com', 'glyphicon glyphicon-triangle-right', lang('menu_support'), 'target="_blank"'];

        //LANGUAGES
        self::$menu[self::$menu_help][1] = ['#', 'glyphicon glyphicon-globe', lang('menu_languages'), '', 'true'];

        for ($lng = 0; $lng < count(lang('#lang_all')); $lng++) {
            self::$submenu[self::$menu_help][1][$lng] = [\eMarket\Settings::langCurrencyPath() . '&language=' . lang('#lang_all')[$lng], 'glyphicon glyphicon-triangle-right', lang('language_name', lang('#lang_all')[$lng]), ''];
        }

        self::$menu[self::$menu_help][2] = ['/', 'glyphicon glyphicon-home', lang('menu_catalog'), 'target="_blank"', 'false'];
        //EXIT
        self::$level[self::$menu_exit] = ['?route=login&logout=ok', lang('menu_exit'), 'false'];
    }

}
