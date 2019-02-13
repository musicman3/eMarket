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
     * @param array $array_pos (массив настроек позиций контроллера)
     * @return array $array_out (массив настроек позиций контроллера и вида)
     */
    public function layoutRouting($array_pos) {

        $SET = new \eMarket\Core\Set;

        foreach ($array_pos as $val) {
            $path_view = str_replace('controller', 'view/' . $SET->template(), $val);
            $array_out[] = $val;
            $array_out[] = $path_view;
        }
        return $array_out;
    }

    /**
     * Вывод всех отсортированных данных в конкретную позицию шаблона
     * 
     * @param string $position (позиция)
     * @return array $return (массив настроек позиций для конкретного пути)
     */
    public function positionRouting($position) {

        $SET = new \eMarket\Core\Set;
        $PDO = new \eMarket\Core\Pdo;

        $return = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=?  ORDER BY sort ASC", [$SET->path(), $position]);

        return self::layoutRouting($return);
    }

}

?>