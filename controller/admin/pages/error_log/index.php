<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */
// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete') == 'delete' && file_exists(ROOT . '/model/work/errors.log')) {
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
    $lines = array();
}
$lines_on_page = $SET->linesOnPage();
$navigate = $NAVIGATION->postLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */
?>