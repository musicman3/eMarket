<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

use eMarket\Core\{
    Settings,
    Pdo,
    Valid
};

/**
 * Header Menu
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class HeaderMenu {

    public static $menu_market = 'market';
    public static $menu_sales = 'sales';
    public static $menu_marketing = 'marketing';
    public static $menu_customers = 'customers';
    public static $menu_tools = 'tools';
    public static $level = [];
    public static $menu = [];
    public static $submenu = [];
    public static $param_1 = [];
    public static $param_2 = [];
    public static $staff_data = false;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->init();
        $this->initModules();
        $this->levelOne();
        $this->staffInit();
        $this->staticLevels();
        $this->exit();
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
            if (method_exists($namespace, 'menu') && $namespace::status() != false) {
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
        self::$level[self::$menu_sales] = ['#', lang('menu_sales'), 'true', 'bi-calculator'];
        self::$level[self::$menu_marketing] = ['#', lang('menu_marketing'), 'true', 'bi-graph-up'];
        self::$level[self::$menu_customers] = ['#', lang('menu_customers'), 'true', 'bi-person-lines-fill'];
        self::$level[self::$menu_tools] = ['#', lang('menu_tools'), 'true', 'bi-tools'];
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
        self::$level['languages'] = ['#', lang('menu_languages'), 'true', 'bi-translate'];
        for ($lng = 0; $lng < count(lang('#lang_all')); $lng++) {
            self::$menu['languages'][$lng] = [Settings::langCurrencyPath() . '&language=' . lang('#lang_all')[$lng], 'bi-caret-right-fill', lang('language_name', lang('#lang_all')[$lng]), '', 'false'];
        }

        //HELP
        self::$level['help'] = ['#', lang('menu_extra'), 'true', 'bi-lightbulb-fill'];
        self::$menu['help'][0] = ['http://emarketforum.com', 'bi-chat-quote', lang('menu_support'), 'target="_blank"', 'false'];
        self::$menu['help'][1] = ['/', 'bi-bag', lang('menu_catalog'), 'target="_blank"', 'false'];
    }

    /**
     * Exit
     *
     */
    public function exit() {
        //EXIT
        self::$level['exit'] = ['?route=login&logout=ok', lang('menu_exit'), 'false', 'bi-box-arrow-right'];
    }

    /**
     * Staff init
     *
     */
    public function staffInit() {
        if (isset($_SESSION['login'])) {
            $staff_permission = Pdo::getValue("SELECT permission FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [$_SESSION['login']]);
            if ($staff_permission != 'admin') {
                self::$staff_data = json_decode(Pdo::getAssoc("SELECT permissions FROM " . TABLE_STAFF_MANAGER . " WHERE id=?", [$staff_permission])[0]['permissions'], 1);

                $menu_array = [];
                foreach (self::$menu as $menu_key => $menu_val) {
                    foreach ($menu_val as $menu_item) {
                        if (in_array($menu_item[0], self::$staff_data)) {
                            $menu_array[$menu_key][] = $menu_item;
                        }

                        if (strpos($menu_item[0], '&language=')) {
                            $lang_string = strstr($menu_item[0], '&language=');
                            foreach (self::$staff_data as $staff_string) {
                                if (strpos($staff_string, $lang_string)) {
                                    $menu_array[$menu_key][] = $menu_item;
                                }
                            }
                        }
                    }
                }

                $level_array = [];
                foreach (self::$level as $key => $val) {
                    if (array_key_exists($key, $menu_array)) {
                        $level_array[$key] = $val;
                    }
                }
                self::$level = $level_array;
                self::$menu = $menu_array;

                $this->permissions();
            }
        }
    }

    /**
     * Permissions
     *
     */
    public function permissions() {
        $count = 0;
        foreach (self::$staff_data as $page) {
            if (strpos('/?route=' . Valid::inGET('route'), $page)) {
                $count++;
            }
            if (Valid::inGET('route') == 'settings/modules/edit') {
                if (strpos('/?route=' . Valid::inGET('route') . '&type=' . Valid::inGET('type') . '&name=' . Valid::inGET('name'), $page)) {
                    $count++;
                }
            }
        }

        if ($count == 0) {
            exit;
        }
    }

}
