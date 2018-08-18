<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

// ********  CONNECT PAGE START  ******** //
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/connect_page_start.php');
// ************************************** //
// 
// Если нажали на кнопку Добавить налог
if ($VALID->inPOST('rate')) {

    // Получаем последний id и увеличиваем его на 1
    $id_tax_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_TAXES . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);
    $id = intval($id_tax_max) + 1;

    // добавляем запись для всех вкладок
    for ($xl = 0; $xl < count($lang_all); $xl++) {
        $PDO->insertPrepare("INSERT INTO " . TABLE_TAXES . " SET id=?, name=?, language=?, rate=?", [$id, $VALID->inPOST($lang_all[$xl]), $lang_all[$xl], $VALID->inPOST('rate')]);
    }
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines_page = 3; // задаем количество строк на странице вывода
$i = 0; // устанавливаем страницу в ноль при заходе
$lines_p = $lines_page;
//Получаем массив таблицы налогов
$lines = $PDO->getColRow("SELECT id, name, rate FROM " . TABLE_TAXES . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);

$counter = $PDO->getRowCount("SELECT id FROM " . TABLE_TAXES . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]); // считаем количество записей налогов

if ($counter <= $lines_page) {
    $lines_p = $counter;
}
// Если нажали на кнопку вперед
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
// Если нажали на кнопку назад
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

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
//
// *********  CONNECT PAGE END  ********* //
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/connect_page_end.php');
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/html_end.php');
// ************************************** //

?>
</body>
</html>