<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete') == 'delete' && file_exists(ROOT . '/model/work/errors.log')) {
    // удаляем лог
    unlink(ROOT . '/model/work/errors.log');

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
if (file_exists(ROOT . '/model/work/errors.log')) { // Если файл существует, то
    // получаем содержимое файла в виде массива и сортируем в обратном порядке
    $lines = array_reverse(file(ROOT . '/model/work/errors.log'));
} else { // если файла нет, то выводим пустой массив
    $lines = [];
}
$lines_on_page = \eMarket\Set::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::postLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>