<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Settings,
    Tree,
    Valid
};
use Cruder\Db;
use eMarket\Admin\BasicSettings;

/**
 * Languages
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
final class Lang {

    public static $count;
    public $db;

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->init();
    }

    /**
     * Init
     *
     */
    private function init(): void {

        if (Valid::inGET('language') && Settings::path() == 'admin' && isset($_SESSION['login']) && isset($_SESSION['pass'])) {

            Db::connect()
                    ->update(TABLE_ADMINISTRATORS)
                    ->set('language', Valid::inGET('language'))
                    ->where('login=', $_SESSION['login'])
                    ->and('password=', $_SESSION['pass'])
                    ->save();
        }

        setlocale(LC_ALL, lang('language_locale'));

        self::$count = count(lang('#lang_all'));
    }

    /**
     * Current branch (admin/catalog/install)
     *
     * @return string
     */
    public static function path(): string {

        return Settings::$lang[Settings::path()];
    }

    /**
     * Including and parsing language files
     *
     * @param string $default_language Default language
     * @param string $marker Marker
     * @return array Languages array
     */
    public static function lang(?string $default_language, ?string $marker = null): array {

        $lang = [];
        $lang_trans = [];
        $ini_lang = [];

        if ($default_language == null OR $default_language == '') {
            $default_language = Settings::basicSettings('primary_language');
        }

        $lang_path = self::path();

        if ($marker == 'admin') {
            $lang_path = 'admin';
        }

        if ($marker == 'catalog') {
            $lang_path = 'catalog';
        }

        $modules_path_array = [];
        $engine_path_array = [];

        if ($marker == null OR $marker == 'admin' OR $marker == 'catalog') {

            if ($marker == null OR $marker == 'admin' OR $marker == 'catalog') {
                $engine_path_array = Tree::filesTree(getenv('DOCUMENT_ROOT') . '/language/' . $default_language . '/' . $lang_path);
            }

            $modules_path = getenv('DOCUMENT_ROOT') . '/modules/';
            $_SESSION['MODULES_INFO'] = Tree::allDirForPath($modules_path, 'true');

            foreach ($_SESSION['MODULES_INFO'] as $modules_type => $modules_names_array) {
                foreach ($modules_names_array as $modules_names) {
                    if (file_exists($modules_path . $modules_type . '/' . $modules_names . '/language/' . $lang_path . '/' . $default_language . '.lng')) {
                        $modules_path_array = array_merge($modules_path_array, [$modules_path . $modules_type . '/' . $modules_names . '/language/' . $lang_path . '/' . $default_language . '.lng']);
                    }
                }
            }

            $files_path = array_reverse(array_merge($engine_path_array, $modules_path_array));

            foreach ($files_path as $files) {
                if (file_exists($files)) {
                    $ini = parse_ini_file($files, FALSE, INI_SCANNER_RAW);
                    $lang = array_merge($lang, $ini);
                }
            }

            if (file_exists(getenv('DOCUMENT_ROOT') . '/custom/language/' . $default_language . '/' . self::path() . '/custom.lng')) {
                $custom_ini = parse_ini_file(getenv('DOCUMENT_ROOT') . '/custom/language/' . $default_language . '/' . self::path() . '/custom.lng', TRUE, INI_SCANNER_RAW);
                $lang = array_merge($lang, $custom_ini);
            }
        }

        if ($marker == 'all' OR $marker == 'translate') {

            $lang_all = [];
            array_push($lang_all, $default_language);

            if (file_exists(getenv('DOCUMENT_ROOT') . '/language/' . $default_language . '/admin/lang.lng')) {
                $lang_trans = parse_ini_file(getenv('DOCUMENT_ROOT') . '/language/' . $default_language . '/admin/lang.lng', TRUE, INI_SCANNER_RAW);
            }
            $lang_dir = scandir(getenv('DOCUMENT_ROOT') . '/language/');

            foreach ($lang_dir as $lang_name) {
                if (!in_array($lang_name, ['.', '..', $default_language])) {
                    array_push($lang_all, $lang_name);
                    if (file_exists(getenv('DOCUMENT_ROOT') . '/language/' . $lang_name . '/admin/lang.lng')) {
                        $ini_lang = parse_ini_file(getenv('DOCUMENT_ROOT') . '/language/' . $lang_name . '/admin/lang.lng', TRUE, INI_SCANNER_RAW);
                    }
                    $lang_trans = array_merge($lang_trans, $ini_lang);
                }
            }
        }

        if (Settings::path() == 'install' && $marker == 'all') {
            return $lang_all;
        }

        if ($marker == 'all') {
            $lang_list = [];
            $lang_available = BasicSettings::$available_languages;
            foreach ($lang_all as $value) {
                if (in_array($value, $lang_available)) {
                    array_push($lang_list, $value);
                }
            }
            return $lang_list;
        }

        if ($marker == 'translate') {
            return $lang_trans;
        }

        return $lang;
    }

    /**
     * Default language setting
     *
     */
    public static function defaultLang(): void {

        if (!isset($_SESSION['DEFAULT_LANGUAGE']) && Settings::path() != 'install') {
            $_SESSION['DEFAULT_LANGUAGE'] = Settings::basicSettings('primary_language');
        }

        if (!Valid::inPOST('language') && Settings::path() == 'install') {
            $_SESSION['DEFAULT_LANGUAGE'] = 'english';
        }

        if (Valid::inPOST('language')) {
            $_SESSION['DEFAULT_LANGUAGE'] = Valid::inPOST('language');
        }
        if (Valid::inGET('language')) {
            $_SESSION['DEFAULT_LANGUAGE'] = Valid::inGET('language');
        }
    }
}
