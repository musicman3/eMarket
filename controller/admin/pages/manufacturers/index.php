<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */

//Если открываем модальное окно, то очищаются папки временных файлов изображений
if ($VALID->inPOST('file_upload') == 'empty') {
    $TREE->filesDirAction(ROOT . '/downloads/upload_handler/files/');
    $TREE->filesDirAction(ROOT . '/downloads/upload_handler/files/thumbnail/');
}
// Если нажали на кнопку Добавить
if ($VALID->inPOST('add')) {

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_MANUFACTURERS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Новый уникальный префикс для файлов
    $prefix = time() . '_';
    // Пишем названия файлов изображений в БД
    $files = glob(ROOT . '/downloads/upload_handler/files/thumbnail/*');
    foreach ($files as $file) {
        if (is_file($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
            // добавляем запись для всех вкладок
            for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
                $PDO->inPrepare("INSERT INTO " . TABLE_MANUFACTURERS . " SET id=?, name=?, language=?, logo=?, site=?", [$id, $VALID->inPOST($SET->titleDir() . '_' . lang('#lang_all')[$xl]), lang('#lang_all')[$xl], $prefix . basename($file), $VALID->inPOST('site')]);
            }
        }
    }

    // Перемещаем файлы
    $TREE->filesDirAction(ROOT . '/downloads/upload_handler/files/thumbnail/', ROOT . '/downloads/images/manufacturers/resize/', $prefix, 'move');
    $TREE->filesDirAction(ROOT . '/downloads/upload_handler/files/', ROOT . '/downloads/images/manufacturers/originals/', $prefix, 'move');
}

// Если нажали на кнопку Редактировать
if ($VALID->inPOST('edit')) {

    for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_MANUFACTURERS . " SET name=?, site=? WHERE id=? AND language=?", [$VALID->inPOST('name_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$xl]), $VALID->inPOST('site_edit'), $VALID->inPOST('edit'), lang('#lang_all')[$xl]]);
    }
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [$VALID->inPOST('delete')]);
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = $PDO->getColRow("SELECT id, name, logo, site FROM " . TABLE_MANUFACTURERS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$lines_on_page = $SET->linesOnPage();
$navigate = $NAVIGATION->getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */

?>