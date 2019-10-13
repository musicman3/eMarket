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

        $str = str_replace('controller', 'view/' . \eMarket\Core\Set::template(), getenv('SCRIPT_FILENAME'));

        return $str;
    }

    /**
     * Роутинг данных из View для административной панели
     *
     * @return string $str (роутинг на view)
     */
    public function routingAdmin() {
        
        if (\eMarket\Core\Valid::inGET('object') != '') {
            $page = \eMarket\Core\Valid::inGET('object') . '.php';
        }

        if (!\eMarket\Core\Valid::inGET('object') OR \eMarket\Core\Valid::inGET('object') == '') {
            $page = 'index.php';
        }

        if (\eMarket\Core\Valid::inGET('route') != '') {
            $str = str_replace('controller', 'view/' . \eMarket\Core\Set::template(), getenv('DOCUMENT_ROOT') . '/controller/' . \eMarket\Core\Set::path() . '/pages/' . \eMarket\Core\Valid::inGET('route') . '/' . $page);
        } else {
            $str = str_replace('controller', 'view/' . \eMarket\Core\Set::template(), getenv('DOCUMENT_ROOT') . '/controller/' . \eMarket\Core\Set::path() . '/pages/dashboard/index.php');
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
        
        if (\eMarket\Core\Valid::inGET('route') != '') {
            $str = str_replace('controller', 'view/' . \eMarket\Core\Set::template(), getenv('DOCUMENT_ROOT') . '/controller/' . \eMarket\Core\Set::path() . '/pages/' . \eMarket\Core\Valid::inGET('route') . '/index.php');
        } else {
            $str = str_replace('controller', 'view/' . \eMarket\Core\Set::template(), getenv('DOCUMENT_ROOT') . '/controller/' . \eMarket\Core\Set::path() . '/pages/catalog/index.php');
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

        $array_pos_temp = \eMarket\Core\Pdo::getColRow("SELECT url, value FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND page=? AND template_name=? ORDER BY sort ASC", [\eMarket\Core\Set::path(), \eMarket\Core\Set::titleDir(), \eMarket\Core\Set::template()]);
        if (count($array_pos_temp) > 0) {
            $array_pos = $array_pos_temp;
            $array_out = [];
            foreach ($array_pos as $val) {
                if ($val[1] == $position) {
                    $path_view = str_replace('controller', 'view/' . \eMarket\Core\Set::template(), $val[0]);
                    $array_out[] = $val[0];
                    $array_out[] = $path_view;
                }
            }
            return $array_out;
        } else {
            $array_pos = \eMarket\Core\Pdo::getColRow("SELECT url, page FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", [\eMarket\Core\Set::path(), $position, \eMarket\Core\Set::template()]);
            $array_out = [];
            foreach ($array_pos as $val) {
                if ($val[1] == 'all') {
                    $path_view = str_replace('controller', 'view/' . \eMarket\Core\Set::template(), $val[0]);
                    $array_out[] = $val[0];
                    $array_out[] = $path_view;
                }
            }
            return $array_out;
        }
    }

}

?>