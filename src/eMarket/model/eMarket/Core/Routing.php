<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Pdo,
    Settings,
    Func,
    JsonRpc,
    Modules,
    Valid
};
use eMarket\Admin\{
    HeaderMenu
};

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

    public static $js_handler = FALSE;
    public static $js_modules_handler = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->jsHandler();
    }

    /**
     * Routing Map
     *
     */
    private function routingMap(): array {
        $routing_parameters = [];
        $path = ucfirst(Settings::path());
        $files = glob(getenv('DOCUMENT_ROOT') . '/model/eMarket/' . $path . '/*');

        foreach ($files as $filename) {
            $namespace = '\eMarket\\' . $path . '\\' . pathinfo($filename, PATHINFO_FILENAME);
            if (isset($namespace::$routing_parameter)) {
                $routing_parameters[$namespace::$routing_parameter] = pathinfo($filename, PATHINFO_FILENAME);
            }
        }

        return $routing_parameters;
    }

    /**
     * Pages routing
     *
     * @return string url
     */
    public function page(): ?string {

        if (Settings::path() == 'catalog') {
            $routing_parameter = 'catalog';
            $class_path = 'Catalog';
        }

        if (Settings::path() == 'admin') {
            new HeaderMenu();
            $routing_parameter = 'dashboard';
            $class_path = 'Admin';
        }

        if (Settings::path() == 'install') {
            $routing_parameter = 'index';
            $class_path = 'Install';
        }

        if (Settings::path() == 'blanks') {
            $routing_parameter = 'BlanksGate';
            $class_path = 'Blanks';
        }

        if (Settings::path() == 'JsonRpc') {
            $jsonrpc = new JsonRpc();
            $routing_parameter = $jsonrpc->decodeGetData('method');
            $class_path = 'JsonRpc';
        }

        if (Valid::inGET('route') != '') {
            $output = $this->routingMap()[Valid::inGET('route')];
        } else {
            $output = $this->routingMap()[$routing_parameter];
        }

        return Func::outputDataFiltering('eMarket\\' . $class_path . '\\' . $output);
    }

    /**
     * Template routing for catalog
     *
     * @return string|bool $str (view routing)
     */
    public static function template(): string|bool {

        $default = 'catalog';

        if (Settings::path() == 'admin') {
            $default = 'dashboard';
        }

        if (Settings::path() == 'install') {
            $default = 'index';
        }

        if (Valid::inGET('route_file') != '') {
            $page = Valid::inGET('route_file') . '.php';
        }

        if (!Valid::inGET('route_file') OR Valid::inGET('route_file') == '') {
            $page = 'index.php';
        }

        if (Valid::inGET('route') != '') {
            $str = str_replace('controller', 'view/' . Settings::template(), getenv('DOCUMENT_ROOT') . '/controller/' . Settings::path() . '/pages/' . Valid::inGET('route') . '/' . $page);
        } else {
            $str = str_replace('controller', 'view/' . Settings::template(), getenv('DOCUMENT_ROOT') . '/controller/' . Settings::path() . '/pages/' . $default . '/index.php');
        }

        if (file_exists($str)) {
            return Func::outputDataFiltering($str);
        }

        return false;
    }

    /**
     * Modules routing
     *
     * @param string $path (path marker controller/view)
     * @return string $str (modules routing)
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

        $array_pos_value = Pdo::getIndex("SELECT url, value FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND page=? AND template_name=? ORDER BY sort ASC", [
                    Settings::path(), Settings::titleDir(), Settings::template()
        ]);

        if (count($array_pos_value) > 0) {
            $array_out = [];
            foreach ($array_pos_value as $val) {
                if ($val[1] == $position) {
                    $array_out[] = str_replace('controller', 'view/' . Settings::template(), $val[0]);
                }
            }
            if ($count == 'count') {
                return count($array_out);
            }
            return $array_out;
        } else {
            $array_pos = Pdo::getIndex("SELECT url, page FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", [
                        Settings::path(), $position, Settings::template()
            ]);
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
     * JS Handler routing
     *
     */
    private function jsHandler(): void {

        if (Settings::path() == 'admin') {
            if (Valid::inGET('route')) {
                $path = getenv('DOCUMENT_ROOT') . '/js_handler/' . Settings::path() . '/pages/' . Valid::inGET('route');
            } else {
                $path = getenv('DOCUMENT_ROOT') . '/js_handler/' . Settings::path() . '/pages/dashboard';
            }
            if (file_exists($path . '/js.php')) {
                self::$js_handler = $path;
            }
        }

        if (Settings::path() == 'catalog') {
            $path = getenv('DOCUMENT_ROOT') . '/js_handler/' . Settings::path() . '/pages/' . Valid::inGET('route');
            if (file_exists($path . '/js.php')) {
                self::$js_handler = $path;
            }
        }

        if (Settings::path() == 'install') {
            $path = getenv('DOCUMENT_ROOT') . '/js_handler/' . Settings::path() . Valid::inGET('route');
            if (file_exists($path . '/js.php')) {
                self::$js_handler = $path;
            }
        }
    }

    /**
     * JS Modules Handler routing
     *
     * @param string $js_path Path to js.php
     */
    public static function jsModulesHandler(?string $js_path = null): void {

        if (Settings::path() == 'admin') {
            $path = self::modules('js_handler');
            if (file_exists($path . '/js.php')) {
                self::$js_modules_handler = $path;
            }
        }

        if (Settings::path() == 'catalog' && $js_path == null) {
            $path = ROOT . '/modules/payment/' . Valid::inPOST('payment_method') . '/js_handler/catalog';
            if (file_exists($path . '/js.php')) {
                self::$js_modules_handler = $path;
            }
        }

        if (Settings::path() == 'catalog' && $js_path != null) {
            $path = ROOT . '/modules/' . $js_path . '/js_handler/catalog';
            if (file_exists($path . '/js.php')) {
                self::$js_modules_handler = $path;
            }
        }
    }

    /**
     * Constructor routing
     *
     * @return string (constructor routing string)
     */
    public function constructor(): string|bool {

        if (Settings::path() == 'admin') {
            return getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/admin/constructor.php';
        }

        if (Settings::path() == 'blanks') {
            return getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/blanks/' . Valid::inGET('blank') . '.php';
        }

        if (Settings::path() == 'catalog' && Valid::inGET('route') !== 'callback') {
            return getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/catalog/constructor.php';
        }

        if (Settings::path() == 'install') {
            return getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/install/constructor.php';
        }

        return false;
    }

}
