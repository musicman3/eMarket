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
     * Роутинг данных из View для административной панели
     *
     * @return string $str (роутинг на view)
     */
    public function routingAdmin() {

        $SET = new \eMarket\Core\Set;
        $VALID = new \eMarket\Core\Valid;
        if ($VALID->inGET('route') != '') {
            $str = str_replace('controller', 'view/' . $SET->template(), getenv('DOCUMENT_ROOT') . '/controller/' . $SET->path() . '/pages/' . $VALID->inGET('route') . '/index.php');
        } else {
            $str = str_replace('controller', 'view/' . $SET->template(), getenv('DOCUMENT_ROOT') . '/controller/' . $SET->path() . '/pages/dashboard/index.php');
        }
        if (file_exists($str)) {
            return $str;
        } else {
            return false;
        }
    }

    /**
     * Роутинг данных из View для каталога
     *
     * @return string $str (роутинг на view)
     */
    public function routingCatalog() {

        $SET = new \eMarket\Core\Set;
        $VALID = new \eMarket\Core\Valid;
        if ($VALID->inGET('route') != '') {
            $str = str_replace('controller', 'view/' . $SET->template(), getenv('DOCUMENT_ROOT') . '/controller/' . $SET->path() . '/pages/' . $VALID->inGET('route') . '/index.php');
        } else {
            $str = str_replace('controller', 'view/' . $SET->template(), getenv('DOCUMENT_ROOT') . '/controller/' . $SET->path() . '/pages/catalog/index.php');
        }
        if (file_exists($str)) {
            return $str;
        } else {
            return false;
        }
    }

    /**
     * Вывод отсортированных слоев в конкретную позицию шаблона
     * 
     * @param string $position (позиция)
     * @return array $array_out (массив настроек позиций для конкретного пути)
     */
    public function layoutRouting($position) {

        $SET = new \eMarket\Core\Set;
        $PDO = new \eMarket\Core\Pdo;

        $array_pos_temp = $PDO->getColRow("SELECT url, value FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND page=? AND template_name=? ORDER BY sort ASC", [$SET->path(), $SET->titleDir(), $SET->template()]);
        if (count($array_pos_temp) > 0) {
            $array_pos = $array_pos_temp;
            $array_out = [];
            foreach ($array_pos as $val) {
                if ($val[1] == $position) {
                    $path_view = str_replace('controller', 'view/' . $SET->template(), $val[0]);
                    $array_out[] = $val[0];
                    $array_out[] = $path_view;
                }
            }
            return $array_out;
        } else {
            $array_pos = $PDO->getColRow("SELECT url, page FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", [$SET->path(), $position, $SET->template()]);
            $array_out = [];
            foreach ($array_pos as $val) {
                if ($val[1] == 'all') {
                    $path_view = str_replace('controller', 'view/' . $SET->template(), $val[0]);
                    $array_out[] = $val[0];
                    $array_out[] = $path_view;
                }
            }
            return $array_out;
        }
    }

}

?>