<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

class Navigation extends Valid {

    /**
     * КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ ДЛЯ GET
     *
     * @param строка $count_lines
     * @param строка $lines_on_page
     * @return массив
     */
    public function getLink($count_lines, $lines_on_page) {

        //$count_lines - общее число строк
        //$lines_on_page - число строк на странице

        $start = 0; // устанавливаем страницу в ноль при заходе
        $finish = $lines_on_page;

        if ($count_lines <= $lines_on_page) {
            $finish = $count_lines;
        }
        // Если нажали на кнопку вперед GET
        if ($this->inGET('finish')) {
            $finish = $this->inGET('finish') + $lines_on_page; // пересчитываем количество строк на странице
            $start = $this->inGET('start') + $lines_on_page; // задаем значение счетчика
            if ($start >= $count_lines) {
                $start = $this->inGET('start');
            }
            if ($finish >= $count_lines) {
                $finish = $count_lines;
            }
        }
        // Если нажали на кнопку назад GET
        if ($count_lines >= $lines_on_page) {
            if ($this->inGET('finish2')) {
                $finish = $this->inGET('start2'); // пересчитываем количество строк на странице
                $start = $this->inGET('start2') - $lines_on_page; // задаем значение счетчика
                if ($start < 0) {
                    $start = 0;
                }
                if ($finish < $lines_on_page) {
                    $finish = $lines_on_page;
                }
            }
        }
        return array($start, $finish);
    }

    /**
     * КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ ДЛЯ POST
     *
     * @param строка $count_lines
     * @param строка $lines_on_page
     * @return массив
     */
    public function postLink($count_lines, $lines_on_page) {

        //$count_lines - общее число строк
        //$lines_on_page - число строк на странице

        $start = 0; // устанавливаем страницу в ноль при заходе
        $finish = $lines_on_page;
        
        if ($count_lines <= $lines_on_page) {
            $finish = $count_lines;
        }
        // Если нажали на кнопку вперед POST
        if ($this->inPOST('finish')) {
            $finish = $this->inPOST('finish') + $lines_on_page; // пересчитываем количество строк на странице
            $start = $this->inPOST('start') + $lines_on_page; // задаем значение счетчика
            if ($start >= $count_lines) {
                $start = $this->inPOST('start');
            }
            if ($finish >= $count_lines) {
                $finish = $count_lines;
            }
        }
        // Если нажали на кнопку назад POST
        if ($count_lines >= $lines_on_page) {
            if ($this->inPOST('finish2')) {
                $finish = $this->inPOST('start2'); // пересчитываем количество строк на странице
                $start = $this->inPOST('start2') - $lines_on_page; // задаем значение счетчика
                if ($start < 0) {
                    $start = 0;
                }
                if ($finish < $lines_on_page) {
                    $finish = $lines_on_page;
                }
            }
        }
        return array($start, $finish);
    }

}

?>