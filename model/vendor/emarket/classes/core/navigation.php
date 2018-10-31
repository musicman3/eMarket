<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

namespace eMarket\Classes\Core;

class Navigation extends Valid {

    //КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
    function getNavi($counter, $l_page) {

        //$counter - общее число строк
        //$l_page - число строк на странице

        $l_start = 0; // устанавливаем страницу в ноль при заходе
        $l_finish = $l_page;

        if ($counter <= $l_page) {
            $l_finish = $counter;
        }
        // Если нажали на кнопку вперед GET
        if ($this->inGET('l_finish')) {
            $l_finish = $this->inGET('l_finish') + $l_page; // пересчитываем количество строк на странице
            $l_start = $this->inGET('l_start') + $l_page; // задаем значение счетчика
            if ($l_start >= $counter) {
                $l_start = $this->inGET('l_start');
            }
            if ($l_finish >= $counter) {
                $l_finish = $counter;
            }
        }
        // Если нажали на кнопку назад GET
        if ($counter >= $l_page) {
            if ($this->inGET('l_finish2')) {
                $l_finish = $this->inGET('i2'); // пересчитываем количество строк на странице
                $l_start = $this->inGET('i2') - $l_page; // задаем значение счетчика
                if ($l_start < 0) {
                    $l_start = 0;
                }
                if ($l_finish < $l_page) {
                    $l_finish = $l_page;
                }
            }
        }

        // Если нажали на кнопку вперед POST
        if ($this->inPOST('l_finish')) {
            $l_finish = $this->inPOST('l_finish') + $l_page; // пересчитываем количество строк на странице
            $l_start = $this->inPOST('l_start') + $l_page; // задаем значение счетчика
            if ($l_start >= $counter) {
                $l_start = $this->inPOST('l_start');
            }
            if ($l_finish >= $counter) {
                $l_finish = $counter;
            }
        }
        // Если нажали на кнопку назад POST
        if ($counter >= $l_page) {
            if ($this->inPOST('l_finish2')) {
                $l_finish = $this->inPOST('i2'); // пересчитываем количество строк на странице
                $l_start = $this->inPOST('i2') - $l_page; // задаем значение счетчика
                if ($l_start < 0) {
                    $l_start = 0;
                }
                if ($l_finish < $l_page) {
                    $l_finish = $l_page;
                }
            }
        }
        $return = array($l_finish, $l_start);
        return $return;
    }

}

?>