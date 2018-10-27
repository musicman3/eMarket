<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

// ********  CONNECT PAGE START  ******** //
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/connect_page_start.php');
// ************************************** //
// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete') == 'delete') {
    // удаляем лог
    unlink($VALID->inSERVER('DOCUMENT_ROOT') . '/model/work/errors.log');
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
if (file_exists($VALID->inSERVER('DOCUMENT_ROOT') . '/model/work/errors.log')) { // Если файл существует, то
    $lines = array_reverse(file($VALID->inSERVER('DOCUMENT_ROOT') . '/model/work/errors.log')); // получаем содержимое файла в виде массива и сортируем в обратном порядке

// Подключаем файл навигации
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/includes/navigation.php');
}

// *********  CONNECT PAGE END  ********* //
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/connect_page_end.php');
// ************************************** //

?>