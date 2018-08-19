<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
//
//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines_page = 3; // задаем количество строк на странице вывода
$i = 0; // устанавливаем страницу в ноль при заходе
$lines_p = $lines_page;

if ($counter <= $lines_page) {
    $lines_p = $counter;
}
// Если нажали на кнопку вперед GET
if ($VALID->inGET('lines_p')) {
    $lines_p = $VALID->inGET('lines_p') + $lines_page; // пересчитываем количество строк на странице
    $i = $VALID->inGET('i') + $lines_page; // задаем значение счетчика
    if ($i >= $counter) {
        $i = $VALID->inGET('i');
    }
    if ($lines_p >= $counter) {
        $lines_p = $counter;
    }
}
// Если нажали на кнопку назад GET
if ($counter >= $lines_page) {
    if ($VALID->inGET('lines_p2')) {
        $lines_p = $VALID->inGET('i2'); // пересчитываем количество строк на странице
        $i = $VALID->inGET('i2') - $lines_page; // задаем значение счетчика
        if ($i < 0) {
            $i = 0;
        }
        if ($lines_p < $lines_page) {
            $lines_p = $lines_page;
        }
    }
}

// Если нажали на кнопку вперед POST
if ($VALID->inPOST('lines_p')) {
    $lines_p = $VALID->inPOST('lines_p') + $lines_page; // пересчитываем количество строк на странице
    $i = $VALID->inPOST('i') + $lines_page; // задаем значение счетчика
    if ($i >= $counter) {
        $i = $VALID->inPOST('i');
    }
    if ($lines_p >= $counter) {
        $lines_p = $counter;
    }
}
// Если нажали на кнопку назад POST
if ($counter >= $lines_page) {
    if ($VALID->inPOST('lines_p2')) {
        $lines_p = $VALID->inPOST('i2'); // пересчитываем количество строк на странице
        $i = $VALID->inPOST('i2') - $lines_page; // задаем значение счетчика
        if ($i < 0) {
            $i = 0;
        }
        if ($lines_p < $lines_page) {
            $lines_p = $lines_page;
        }
    }
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ

?>