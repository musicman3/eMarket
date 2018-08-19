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
if ($VALID->inPOST('log_delete') == 'delete') {
    // удаляем лог
    unlink($VALID->inSERVER('DOCUMENT_ROOT') . '/model/work/errors.log');
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = array();

if (file_exists($VALID->inSERVER('DOCUMENT_ROOT') . '/model/work/errors.log')) { // Если файл существует, то
    $lines = file($VALID->inSERVER('DOCUMENT_ROOT') . '/model/work/errors.log'); // получаем содержимое файла в виде массива
    $lines = array_reverse($lines); // сортируем в обратном порядке
    $counter = count($lines); // считаем количество строк

// Подключаем файл навигации
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/includes/navigation.php');
}
//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
// *********  CONNECT PAGE END  ********* //
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/connect_page_end.php');
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/html_end.php');
// ************************************** //

?>
</body>
</html>