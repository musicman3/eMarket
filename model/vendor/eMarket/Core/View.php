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
            if ($val == $position) {
                $path_view = str_replace('controller', 'view/' . $SET->template(), $key);
                require_once (getenv('DOCUMENT_ROOT') . $key);
                require_once (getenv('DOCUMENT_ROOT') . $path_view);
            }
        }
    }

    /**
     * Роутинг данных из View
     * 
     * @param array $array_in (массив настроек позиций)
     * @return array $array (массив настроек позиций для конкретного пути)
     */
    public function layoutRoutingFilter($array_in) {
        
        $SET = new \eMarket\Core\Set;

        foreach ($array_in as $key => $val) {

            if (strpos($key, $SET->path()) == TRUE) {

                $array_out[$key] = $val;
            }
        }

        return $array_out;
    }

}

?>