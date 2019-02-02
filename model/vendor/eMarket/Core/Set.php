<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Класс для получения установок, настроек и др.
 *
 * @package Set
 * @author eMarket
 * 
 */
class Set {

    /**
     * Название текущего шаблона
     *
     * @return string
     */
    public function template() {
        $template = 'default';
        return $template;
    }

    /**
     * Текущая ветка (admin или catalog)
     *
     * @return string
     */
    public function path() {
        $VALID = new \eMarket\Core\Valid;
        $path = explode('/', ($VALID->inSERVER('REQUEST_URI')))[2];
        return $path;
    }

    /**
     * Текущая директория
     *
     * @return string
     */
    public function titleDir() {
        $title_dir = basename(getcwd());
        return $title_dir;
    }

    /**
     * Считываем значение строк на странице
     *
     * @return string
     */
    public function linesOnPage() {
        $PDO = new \eMarket\Core\Pdo;
        $lines_on_page = $PDO->selectPrepare("SELECT lines_on_page FROM " . TABLE_BASIC_SETTINGS, []);
        return $lines_on_page;
    }

    /**
     * Считываем значение времени сессии администратора
     *
     * @return string
     */
    public function sessionExprTime() {
        $PDO = new \eMarket\Core\Pdo;
        $session_expr_time = $PDO->selectPrepare("SELECT session_expr_time FROM " . TABLE_BASIC_SETTINGS, []);
        return $session_expr_time;
    }

    /**
     * Отображаем Select с учетом значения по-умолчанию
     *
     * @param array (массив для Select)
     * @param string (если не нужно Selected)
     */
    public function viewSelect($value, $selected = null) {
        
        $count_value = count($value);
        for ($x = 0; $x < $count_value; $x++) {
            if (isset($value[$x][1]) && $value[$x][1] == 1 && $selected != false) {

                ?>
                <!-- Строка Select по умолчанию-->
                <option selected><?php echo $value[$x][0] ?></option>
            <?php } else { ?>
                <option><?php echo $value[$x][0] ?></option>
                <?php
            }
        }
    }

}

?>