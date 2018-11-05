<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

namespace eMarket\Classes\Core;

class Navigation extends Valid {

    //КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
    function getLink($count_lines, $lines_of_page) {

        //$count_lines - общее число строк
        //$lines_of_page - число строк на странице

        $start = 0; // устанавливаем страницу в ноль при заходе
        $finish = $lines_of_page;

        if ($count_lines <= $lines_of_page) {
            $finish = $count_lines;
        }
        // Если нажали на кнопку вперед GET
        if ($this->inGET('finish')) {
            $finish = $this->inGET('finish') + $lines_of_page; // пересчитываем количество строк на странице
            $start = $this->inGET('start') + $lines_of_page; // задаем значение счетчика
            if ($start >= $count_lines) {
                $start = $this->inGET('start');
            }
            if ($finish >= $count_lines) {
                $finish = $count_lines;
            }
        }
        // Если нажали на кнопку назад GET
        if ($count_lines >= $lines_of_page) {
            if ($this->inGET('finish2')) {
                $finish = $this->inGET('start2'); // пересчитываем количество строк на странице
                $start = $this->inGET('start2') - $lines_of_page; // задаем значение счетчика
                if ($start < 0) {
                    $start = 0;
                }
                if ($finish < $lines_of_page) {
                    $finish = $lines_of_page;
                }
            }
        }
        return array($start, $finish);
    }

    //КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
    function postLink($count_lines, $lines_of_page) {

        //$count_lines - общее число строк
        //$lines_of_page - число строк на странице

        $start = 0; // устанавливаем страницу в ноль при заходе
        $finish = $lines_of_page;

        // Если нажали на кнопку вперед POST
        if ($this->inPOST('finish')) {
            $finish = $this->inPOST('finish') + $lines_of_page; // пересчитываем количество строк на странице
            $start = $this->inPOST('start') + $lines_of_page; // задаем значение счетчика
            if ($start >= $count_lines) {
                $start = $this->inPOST('start');
            }
            if ($finish >= $count_lines) {
                $finish = $count_lines;
            }
        }
        // Если нажали на кнопку назад POST
        if ($count_lines >= $lines_of_page) {
            if ($this->inPOST('finish2')) {
                $finish = $this->inPOST('start2'); // пересчитываем количество строк на странице
                $start = $this->inPOST('start2') - $lines_of_page; // задаем значение счетчика
                if ($start < 0) {
                    $start = 0;
                }
                if ($finish < $lines_of_page) {
                    $finish = $lines_of_page;
                }
            }
        }
        return array($start, $finish);
    }

}

?>