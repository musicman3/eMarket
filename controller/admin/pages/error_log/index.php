<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

// ********  CONNECT PAGE START  ******** //
require_once(getenv('DOCUMENT_ROOT') . '/model/connect_page_start.php');
// ************************************** //
// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete') == 'delete') {
    // удаляем лог
    unlink(ROOT . '/model/work/errors.log');
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
if (file_exists(ROOT . '/model/work/errors.log')) { // Если файл существует, то
    //КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
    $lines = array_reverse(file(ROOT . '/model/work/errors.log')); // получаем содержимое файла в виде массива и сортируем в обратном порядке
    $navigate = $NAVIGATOR->getNavi(count($lines), $l_page = 20);
    $l_finish = $navigate[0];
    $l_start = $navigate[1];
}

// *********  CONNECT PAGE END  ********* //
require_once(ROOT . '/model/connect_page_end.php');
// ************************************** //

?>