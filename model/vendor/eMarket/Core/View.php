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
     * @param string $path (путь к подключаемому файлу)
     */
    public function layoutRouting($path) {

        $SET = new \eMarket\Core\Set;

        $path_view = str_replace('controller', 'view/' . $SET->template(), $path);

        require_once ($path);
        require_once ($path_view);
    }

}

?>