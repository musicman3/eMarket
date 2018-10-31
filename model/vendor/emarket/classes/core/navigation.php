<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

namespace eMarket\Classes\Core;

class Navigation extends Valid {

    //КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
    function getNavi($counter, $count_lines) {

        //$counter - общее число строк
        //$count_lines - число строк на странице

        $start = 0; // устанавливаем страницу в ноль при заходе
        $finish = $count_lines;

        if ($counter <= $count_lines) {
            $finish = $counter;
        }
        // Если нажали на кнопку вперед GET
        if ($this->inGET('finish')) {
            $finish = $this->inGET('finish') + $count_lines; // пересчитываем количество строк на странице
            $start = $this->inGET('start') + $count_lines; // задаем значение счетчика
            if ($start >= $counter) {
                $start = $this->inGET('start');
            }
            if ($finish >= $counter) {
                $finish = $counter;
            }
        }
        // Если нажали на кнопку назад GET
        if ($counter >= $count_lines) {
            if ($this->inGET('finish2')) {
                $finish = $this->inGET('start2'); // пересчитываем количество строк на странице
                $start = $this->inGET('start2') - $count_lines; // задаем значение счетчика
                if ($start < 0) {
                    $start = 0;
                }
                if ($finish < $count_lines) {
                    $finish = $count_lines;
                }
            }
        }

        // Если нажали на кнопку вперед POST
        if ($this->inPOST('finish')) {
            $finish = $this->inPOST('finish') + $count_lines; // пересчитываем количество строк на странице
            $start = $this->inPOST('start') + $count_lines; // задаем значение счетчика
            if ($start >= $counter) {
                $start = $this->inPOST('start');
            }
            if ($finish >= $counter) {
                $finish = $counter;
            }
        }
        // Если нажали на кнопку назад POST
        if ($counter >= $count_lines) {
            if ($this->inPOST('finish2')) {
                $finish = $this->inPOST('start2'); // пересчитываем количество строк на странице
                $start = $this->inPOST('start2') - $count_lines; // задаем значение счетчика
                if ($start < 0) {
                    $start = 0;
                }
                if ($finish < $count_lines) {
                    $finish = $count_lines;
                }
            }
        }
        $return = array($finish, $start);
        return $return;
    }

}

?>