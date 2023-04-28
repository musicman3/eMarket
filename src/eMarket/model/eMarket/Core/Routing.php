<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Debug,
    Settings,
    Func,
    JsonRpc,
    Modules,
    Tree,
    Valid
};
use Cruder\Db;
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
     * Page processor (route logic for page)
     *
     * @param string $path (route path)
     * @return string (output path)
     */
    public static function pageProcessor(string $path): string {

        $output = self::pageNotFound($path); // "Page not found" check
        return $output;
    }

    /**
     * Page Not Found
     *
     * @param string $path (route path)
     * @return string (output path)
     */
    public static function pageNotFound(string $path): string {

        foreach (self::routingMap() as $key => $page) {
            if ($path == $key) {
                return $path;
            }
        }

        $page = 'page_not_found';
        return $page;
    }

    /**
     * Routing path
     *
     * @return string $page (routing path)
     */
    public static function routingPath(): string {

        $page = Settings::$default_page[Settings::path()];

        if (Valid::inGET('route') != '') {
            $page = self::pageProcessor(Valid::inGET('route'));
        }

        return $page;
    }

    /**
     * Routing Map
     *
     * @return array (Routing Map array)
     */
    public static function routingMap(): array {
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
     * @return string|null url
     */
    public function page(): ?string {

        if (Settings::path() == 'catalog') {
            $default_routing_parameter = 'catalog';
            $class_path = 'eMarket\Catalog';
        }

        if (Settings::path() == 'admin') {
            new HeaderMenu();
            $default_routing_parameter = Settings::defaultPage();
            $class_path = 'eMarket\Admin';
        }

        if (Settings::path() == 'install') {
            $default_routing_parameter = 'index';
            $class_path = 'eMarket\Install';
        }

        if (Settings::path() == 'uploads') {
            $default_routing_parameter = 'uploads';
            $class_path = 'eMarket\Uploads';
        }

        if (Settings::path() == 'JsonRpc') {
            $jsonrpc = new JsonRpc();
            $default_routing_parameter = $jsonrpc->decodeGetData('method');
            $class_path = 'eMarket\JsonRpc';
        }

        if (Valid::inGET('route') != '') {
            $page = self::pageProcessor(Valid::inGET('route'));
            return Func::outputDataFiltering($class_path . '\\' . self::routingMap()[$page]);
        }

        return Func::outputDataFiltering($class_path . '\\' . self::routingMap()[$default_routing_parameter]);
    }

    /**
     * Template routing for catalog
     *
     * @return string|bool (view routing)
     */
    public static function template(): string|bool {

        $page_dir = self::routingPath();

        if (Valid::inGET('route_file') != '') {
            $page = Valid::inGET('route_file') . '.php';
        }

        if (!Valid::inGET('route_file') OR Valid::inGET('route_file') == '') {
            $page = 'index.php';
        }

        $str = str_replace('controller', 'view/' . Settings::template(), getenv('DOCUMENT_ROOT') . '/controller/' . Settings::path() . '/pages/' . $page_dir . '/' . $page);

        if (file_exists($str)) {
            return Func::outputDataFiltering($str);
        }

        return false;
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

        $array_pos_value = Db::connect()
                ->read(TABLE_TEMPLATE_CONSTRUCTOR)
                ->selectIndex('url, value')
                ->where('group_id=', Settings::path())
                ->and('page=', $page)
                ->and('template_name=', Settings::template())
                ->orderByAsc('sort')
                ->save();

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
     * JS Handler routing
     *
     */
    private function jsHandler(): void {

        if (Settings::path() == 'admin') {
            if (Valid::inGET('route')) {
                $path = getenv('DOCUMENT_ROOT') . '/js_handler/' . Settings::path() . '/pages/' . Valid::inGET('route');
            } else {
                $path = getenv('DOCUMENT_ROOT') . '/js_handler/' . Settings::path() . '/pages/' . Settings::defaultPage();
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

        $constructor_list = Tree::filesTree(getenv('DOCUMENT_ROOT') . '/model/eMarket/Constructor');

        $constructor_data = [];
        foreach ($constructor_list as $val) {
            $namespace = 'eMarket\Constructor\\' . pathinfo($val, PATHINFO_FILENAME);
            if ($namespace::init()) {
                $constructor_data[$namespace] = $namespace::init();
            }
        }

        if (count($constructor_data) > 1) {
            echo '<pre><b>Attention! Conflict inside the constructor. See data:</b></pre>';

            Debug::trace($constructor_data);
            return false;
        } else {
            return current($constructor_data);
        }
    }

}
