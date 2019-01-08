<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

class Navigation {

    /**
     * КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ ДЛЯ GET
     *
     * @param строка $count_lines
     * @param строка $lines_on_page
     * @param строка integer $transfer
     * @return массив
     */
    public function getLink($count_lines, $lines_on_page, int $transfer = null) {

        //$count_lines - общее число строк
        //$lines_on_page - число строк на странице

        $VALID = new \eMarket\Core\Valid;

        $start = 0; // устанавливаем страницу в ноль при заходе
        $finish = $lines_on_page;

        if ($count_lines <= $lines_on_page) {
            $finish = $count_lines;
        }

        if ($start == 0 && $finish >= $lines_on_page + $transfer && $transfer != null) {
            return array($start, $finish + $transfer);
        }
        
        if ($start == 0 && $count_lines >= $lines_on_page + $transfer && $transfer != null) {
            $finish = $finish + $transfer;
        }

        // Если нажали на кнопку вперед GET
        if ($VALID->inGET('finish')) {
            $finish = $VALID->inGET('finish') + $lines_on_page; // пересчитываем количество строк на странице
            $start = $VALID->inGET('start') + $lines_on_page; // задаем значение счетчика
            if ($start >= $count_lines) {
                $start = $VALID->inGET('start');
            }
            if ($finish >= $count_lines) {
                $finish = $count_lines;
            }
            return array($start, $finish);
        }
        // Если нажали на кнопку назад GET
        if ($count_lines > $lines_on_page && $VALID->inGET('finish2')) {
            $finish = $VALID->inGET('start2'); // пересчитываем количество строк на странице
            $start = $VALID->inGET('start2') - $lines_on_page; // задаем значение счетчика
            if ($start < 0) {
                $start = 0;
            }
            if ($finish < $lines_on_page) {
                $finish = $lines_on_page;
            }
            return array($start, $finish + $transfer);
        }

        return array($start, $finish);
    }

    /**
     * КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ ДЛЯ POST
     *
     * @param строка $count_lines
     * @param строка $lines_on_page
     * @param строка integer $transfer
     * @return массив
     */
    public function postLink($count_lines, $lines_on_page, int $transfer = null) {

        //$count_lines - общее число строк
        //$lines_on_page - число строк на странице

        $VALID = new \eMarket\Core\Valid;

        $start = 0; // устанавливаем страницу в ноль при заходе
        $finish = $lines_on_page;

        if ($count_lines <= $lines_on_page) {
            $finish = $count_lines;
        }

        if ($start == 0 && $finish >= $lines_on_page + $transfer && $transfer != null) {
            return array($start, $finish + $transfer);
        }
        
        if ($start == 0 && $count_lines >= $lines_on_page + $transfer && $transfer != null) {
            $finish = $finish + $transfer;
        }

        // Если нажали на кнопку вперед POST
        if ($VALID->inPOST('finish')) {
            $finish = $VALID->inPOST('finish') + $lines_on_page; // пересчитываем количество строк на странице
            $start = $VALID->inPOST('start') + $lines_on_page; // задаем значение счетчика
            if ($start >= $count_lines) {
                $start = $VALID->inPOST('start');
            }
            if ($finish >= $count_lines) {
                $finish = $count_lines;
            }
            return array($start, $finish);
        }
        // Если нажали на кнопку назад POST
        if ($count_lines > $lines_on_page && $VALID->inPOST('finish2')) {
            $finish = $VALID->inPOST('start2'); // пересчитываем количество строк на странице
            $start = $VALID->inPOST('start2') - $lines_on_page; // задаем значение счетчика
            if ($start < 0) {
                $start = 0;
            }
            if ($finish < $lines_on_page) {
                $finish = $lines_on_page;
            }
            return array($start, $finish + $transfer);
        }

        return array($start, $finish);
    }

}

?>