<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

class Lang {

    /**
     * Подключение и парсинг языковых файлов
     *
     * @param строка $default_language
     * @param строка $marker (маркер)
     * @return массив $lang
     * @return массив $lang_all
     * @return массив $lang_trans
     */
    function lang($default_language, $marker = null) {

        $TREE = new \eMarket\Core\Tree;
        $SET = new \eMarket\Core\Set;
        
        //Получаем список путей к языковым файлам
        $files_path = $TREE->filesTree(getenv('DOCUMENT_ROOT') . '/language/' . $default_language . '/' . $SET->path());
        //Парсинг языковых файлов
        $lang = parse_ini_file($files_path[0], FALSE, INI_SCANNER_RAW);
        for ($i = 0; $i < count($files_path); $i++) {
            $ini = parse_ini_file($files_path[$i], FALSE, INI_SCANNER_RAW);
            $lang = array_merge($lang, $ini); // Установка языкового массива
        }

        //Получение списка языков
        $lang_all = array(); // массив с языками
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
        if ($marker == 'all') {
            return $lang_all;
        }
        if ($marker == 'translate') {
            return $lang_trans;
        }

        return $lang;
    }

}

?>