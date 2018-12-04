<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

class Set {

    /**
     * Название текущего шаблона
     *
     * @return строка
     */
    public function template() {
        $template = 'default';
        return $template;
    }

    /**
     * Текущая ветка (admin или catalog)
     *
     * @return строка
     */
    public function path() {
        $VALID = new \eMarket\Core\Valid;
        $path = explode('/', ($VALID->inSERVER('REQUEST_URI')))[2];
        return $path;
    }

    /**
     * Текущая директория
     *
     * @return строка
     */
    public function titleDir() {
        $title_dir = basename(getcwd());
        return $title_dir;
    }

    /**
     * Считываем значение строк на странице
     *
     * @return строка
     */
    public function linesOnPage() {
        $PDO = new \eMarket\Core\Pdo;
        $lines_on_page = $PDO->selectPrepare("SELECT lines_on_page FROM " . TABLE_BASIC_SETTINGS, []);
        return $lines_on_page;
    }

    /**
     * Считываем значение времени сессии администратора
     *
     * @return строка
     */
    public function sessionExprTime() {
        $PDO = new \eMarket\Core\Pdo;
        $session_expr_time = $PDO->selectPrepare("SELECT session_expr_time FROM " . TABLE_BASIC_SETTINGS, []);
        return $session_expr_time;
    }

}

?>