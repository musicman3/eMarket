<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */
//
// Загружаем движок EAC
$EAC_ENGINE = $EAC->start(TABLE_CATEGORIES);
$idsx_real_parent_id = $EAC_ENGINE[0];
$parent_id = $EAC_ENGINE[1];

// КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
// 
// Устанавливаем родительскую категорию при навигации назад-вперед
if ($VALID->inGET('parent_id_temp')) {
    $parent_id = $VALID->inGET('parent_id_temp');
}

// задаем количество строк на странице вывода категорий
if (!isset($_SESSION['select_category'])) {
    $_SESSION['select_category'] = $SET->linesOnPage();
    $lines_on_page = $_SESSION['select_category'];
} elseif (isset($_SESSION['select_category']) && $VALID->inGET('select_row')) {
    $_SESSION['select_category'] = $VALID->inGET('select_row');
    $lines_on_page = $_SESSION['select_category'];
} else {
    $lines_on_page = $_SESSION['select_category'];
}

// получаем отсортированное по sort_category содержимое в виде массива для отображения на странице и сортируем в обратном порядке
$lines = array_reverse($PDO->getColRow("SELECT * FROM " . TABLE_CATEGORIES . " WHERE parent_id=? AND language=? ORDER BY sort_category DESC", [$parent_id, lang('#lang_all')[0]]));
$count_lines = count($lines);  //считаем количество строк

$navigate = $NAVIGATION->getLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

// КОНЕЦ-> КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
// 
// Сортировка мышкой EAC
$EAC->sortMouse(TABLE_CATEGORIES, $TOKEN);

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */
?>
