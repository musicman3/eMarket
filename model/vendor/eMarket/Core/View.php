<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Класс для шаблонизатора
 *
 * @package View
 * @author eMarket
 * 
 */
class View {

    /**
     * Роутинг данных из View
     *
     * @return string $str (роутинг на view)
     */
    public function routing() {

        $SET = new \eMarket\Core\Set;

        $str = str_replace('controller', 'view/' . $SET->template(), getenv('SCRIPT_FILENAME'));

        return $str;
    }

    /**
     * Роутинг слоев (layouts)
     *
     * @param string $position (позиция на странице)
     * @param array $array_pos (массив настроек позиций)
     */
    public function layoutRouting($position, $array_pos) {

        $SET = new \eMarket\Core\Set;

        foreach ($array_pos as $key => $val) {
            if ($val == $position && strpos($key, $SET->path()) == TRUE) {
                $path_view = str_replace('controller', 'view/' . $SET->template(), $key);
                require_once (getenv('DOCUMENT_ROOT') . $key);
                require_once (getenv('DOCUMENT_ROOT') . $path_view);
            }
        }
    }

}

?>