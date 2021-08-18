<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Pdo,
    Settings,
    Tree,
    Valid
};

/**
 * Languages
 *
 * @package Lang
 * @author eMarket
 * 
 */
final class Lang {

    public static $count;

    /**
     * Init
     *
     */
    public static function init() {

        if (Valid::inGET('language') && Settings::path() == 'admin' && isset($_SESSION['login']) && isset($_SESSION['pass'])) {
            Pdo::action("UPDATE " . TABLE_ADMINISTRATORS . " SET language=? WHERE login=? AND password=?", [
                Valid::inGET('language'), $_SESSION['login'], $_SESSION['pass']
            ]);
        }

        setlocale(LC_ALL, lang('language_locale'));

        self::$count = count(lang('#lang_all'));
    }

    /**
     * Including and parsing language files
     *
     * @param string $default_language Default language
     * @param string $marker Marker
     * @return array $lang|$lang_all|$lang_trans
     */
    public static function lang($default_language, $marker = null) {

        if ($default_language == null OR $default_language == '') {
            $default_language = Settings::basicSettings('primary_language');
        }

        if ($marker == null) {
            $engine_path_array = Tree::filesTree(getenv('DOCUMENT_ROOT') . '/language/' . $default_language . '/' . Settings::path());

            $modules_path = getenv('DOCUMENT_ROOT') . '/modules/';
            $_SESSION['MODULES_INFO'] = Tree::allDirForPath($modules_path, 'true');

            $modules_path_array = [];
            foreach ($_SESSION['MODULES_INFO'] as $modules_type => $modules_names_array) {
                foreach ($modules_names_array as $modules_names) {
                    $modules_path_array = array_merge($modules_path_array, [$modules_path . $modules_type . '/' . $modules_names . '/language/' . $default_language . '.lng']);
                }
            }

            $files_path = array_merge($engine_path_array, $modules_path_array);

            $lang = parse_ini_file($files_path[0], FALSE, INI_SCANNER_RAW);
            foreach ($files_path as $files) {
                $ini = parse_ini_file($files, FALSE, INI_SCANNER_RAW);
                $lang = array_merge($lang, $ini);
            }
        }

        if ($marker == 'all' OR $marker == 'translate') {

            $lang_all = [];
            array_push($lang_all, $default_language);

            $lang_trans = parse_ini_file(getenv('DOCUMENT_ROOT') . '/language/' . $default_language . '/admin/lang.lng', TRUE, INI_SCANNER_RAW);
            $lang_dir = scandir(getenv('DOCUMENT_ROOT') . '/language/');

            foreach ($lang_dir as $lang_name) {
                if (!in_array($lang_name, array('.', '..', $default_language))) {
                    array_push($lang_all, $lang_name);
                    $ini_lang = parse_ini_file(getenv('DOCUMENT_ROOT') . '/language/' . $lang_name . '/admin/lang.lng', TRUE, INI_SCANNER_RAW);
                    $lang_trans = array_merge($lang_trans, $ini_lang);
                }
            }
        }

        if ($marker == 'all') {
            return $lang_all;
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
    public static function defaultLang() {

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
