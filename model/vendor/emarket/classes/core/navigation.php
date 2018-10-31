<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

namespace eMarket\Classes\Core;

class Navigation extends Valid {

    //КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
    function getNavi($counter, $lines_page) {

        //$counter - общее число строк
        //$lines_page - чисто строк на странице

        $i = 0; // устанавливаем страницу в ноль при заходе
        $lines_p = $lines_page;

        if ($counter <= $lines_page) {
            $lines_p = $counter;
        }
        // Если нажали на кнопку вперед GET
        if ($this->inGET('lines_p')) {
            $lines_p = $this->inGET('lines_p') + $lines_page; // пересчитываем количество строк на странице
            $i = $this->inGET('i') + $lines_page; // задаем значение счетчика
            if ($i >= $counter) {
                $i = $this->inGET('i');
            }
            if ($lines_p >= $counter) {
                $lines_p = $counter;
            }
        }
        // Если нажали на кнопку назад GET
        if ($counter >= $lines_page) {
            if ($this->inGET('lines_p2')) {
                $lines_p = $this->inGET('i2'); // пересчитываем количество строк на странице
                $i = $this->inGET('i2') - $lines_page; // задаем значение счетчика
                if ($i < 0) {
                    $i = 0;
                }
                if ($lines_p < $lines_page) {
                    $lines_p = $lines_page;
                }
            }
        }

        // Если нажали на кнопку вперед POST
        if ($this->inPOST('lines_p')) {
            $lines_p = $this->inPOST('lines_p') + $lines_page; // пересчитываем количество строк на странице
            $i = $this->inPOST('i') + $lines_page; // задаем значение счетчика
            if ($i >= $counter) {
                $i = $this->inPOST('i');
            }
            if ($lines_p >= $counter) {
                $lines_p = $counter;
            }
        }
        // Если нажали на кнопку назад POST
        if ($counter >= $lines_page) {
            if ($this->inPOST('lines_p2')) {
                $lines_p = $this->inPOST('i2'); // пересчитываем количество строк на странице
                $i = $this->inPOST('i2') - $lines_page; // задаем значение счетчика
                if ($i < 0) {
                    $i = 0;
                }
                if ($lines_p < $lines_page) {
                    $lines_p = $lines_page;
                }
            }
        }
        $return = array($lines_p, $i);
        return $return;
    }

}

?>