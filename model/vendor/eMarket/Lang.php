<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Языковой класс
 *
 * @package Lang
 * @author eMarket
 * 
 */
final class Lang {

    public static $COUNT;

    /**
     * Подключение и парсинг языковых файлов
     *
     * @param string $default_language (язык по умолчанию)
     * @param string $marker (маркер)
     * @return array $lang|$lang_all|$lang_trans
     */
    public static function lang($default_language, $marker = null) {

        if ($marker == null) {
            //Получаем массив со списком путей к языковым файлам движка
            $engine_path_array = \eMarket\Tree::filesTree(getenv('DOCUMENT_ROOT') . '/language/' . $default_language . '/' . \eMarket\Settings::path());

            // Получаем список путей к языковым файлам модулей
            $modules_path = getenv('DOCUMENT_ROOT') . '/modules/';
            $_SESSION['MODULES_INFO'] = \eMarket\Tree::allDirForPath($modules_path, 'true');

            // Готовим массив со списком путей к языковым файлам модулей
            $modules_path_array = [];
            foreach ($_SESSION['MODULES_INFO'] as $modules_type => $modules_names_array) {
                foreach ($modules_names_array as $modules_names) {
                    $modules_path_array = array_merge($modules_path_array, [$modules_path . $modules_type . '/' . $modules_names . '/language/' . $default_language . '.lng']);
                }
            }

            // Сливаем вместе списки путей к языковым файлам и записываем в сессию
            $files_path = array_merge($engine_path_array, $modules_path_array);

            //Парсинг языковых файлов
            $lang = parse_ini_file($files_path[0], FALSE, INI_SCANNER_RAW);
            foreach ($files_path as $files) {
                $ini = parse_ini_file($files, FALSE, INI_SCANNER_RAW);
                $lang = array_merge($lang, $ini); // Установка языкового массива
            }
        }

        if ($marker == 'all' OR $marker == 'translate') {

            //Получение списка языков
            $lang_all = []; // массив с языками
            array_push($lang_all, $default_language); // первым в массиве идет язык по умолчанию

            $lang_trans = parse_ini_file(getenv('DOCUMENT_ROOT') . '/language/' . $default_language . '/admin/lang.lng', TRUE, INI_SCANNER_RAW);
            $lang_dir = scandir(getenv('DOCUMENT_ROOT') . '/language/');

            foreach ($lang_dir as $lang_name) {
                // Собираем данные для списка языков
                if (!in_array($lang_name, array('.', '..', $default_language))) {
                    array_push($lang_all, $lang_name);
                    // Собираем данные из всех general.lng
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
     * Установка языка по умолчанию
     *
     */
    public static function defaultLang() {

        //Если пользователь не авторизован, то устанавливаем язык по умолчанию
        if (!isset($_SESSION['DEFAULT_LANGUAGE']) && \eMarket\Settings::path() != 'install') {
            $_SESSION['DEFAULT_LANGUAGE'] = DEFAULT_LANGUAGE;
        }

        //Если первый раз в инсталляторе, то устанавливаем язык по умолчанию Russian
        if (!\eMarket\Valid::inPOST('language') && \eMarket\Settings::path() == 'install') {
            $_SESSION['DEFAULT_LANGUAGE'] = 'russian';
        }

        //Если переключили язык не авторизованно или в инсталляторе
        if (\eMarket\Valid::inPOST('language')) {
            $_SESSION['DEFAULT_LANGUAGE'] = \eMarket\Valid::inPOST('language');
        }
        if (\eMarket\Valid::inGET('language')) {
            $_SESSION['DEFAULT_LANGUAGE'] = \eMarket\Valid::inGET('language');
        }
    }

    /**
     * Инициализация / Init
     *
     */
    public static function init() {

        if (\eMarket\Valid::inGET('language') && \eMarket\Settings::path() == 'admin' && isset($_SESSION['login']) && isset($_SESSION['pass'])) {
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_ADMINISTRATORS . " SET language=? WHERE login=? AND password=?", [\eMarket\Valid::inGET('language'), $_SESSION['login'], $_SESSION['pass']]);
        }

        setlocale(LC_ALL, lang('language_locale'));

        self::$COUNT = count(lang('#lang_all'));
    }

}

?>