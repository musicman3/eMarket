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
    $image_list = '';
    // Составляем список файлов изображений
    $files = glob(ROOT . '/downloads/upload_handler/files/thumbnail/*');
    foreach ($files as $file) {
        if (is_file($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
            $image_list .= $prefix . basename($file) . ',';
        }
    }
    // добавляем запись для всех вкладок
    for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_MANUFACTURERS . " SET id=?, name=?, language=?, logo=?, site=?", [$id, $VALID->inPOST($SET->titleDir() . '_' . lang('#lang_all')[$xl]), lang('#lang_all')[$xl], $image_list, $VALID->inPOST('site')]);
    }

    // Перемещаем файлы из временной папки в постоянную
    $TREE->filesDirAction(ROOT . '/downloads/upload_handler/files/thumbnail/', ROOT . '/downloads/images/manufacturers/resize/', $prefix);
    $TREE->filesDirAction(ROOT . '/downloads/upload_handler/files/', ROOT . '/downloads/images/manufacturers/originals/', $prefix);
}

// Если нажали на кнопку Редактировать
if ($VALID->inPOST('edit')) {

    // Новый уникальный префикс для файлов
    $prefix = time() . '_';
    $image_list = $PDO->selectPrepare("SELECT logo FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [$VALID->inPOST('edit')]);
    // Составляем список файлов изображений
    $files = glob(ROOT . '/downloads/upload_handler/files/thumbnail/*');
    foreach ($files as $file) {
        if (is_file($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
            $image_list .= $prefix . basename($file) . ',';
        }
    }

    for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_MANUFACTURERS . " SET name=?, site=?, logo=? WHERE id=? AND language=?", [$VALID->inPOST('name_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$xl]), $VALID->inPOST('site_edit'), $image_list, $VALID->inPOST('edit'), lang('#lang_all')[$xl]]);
    }

    // Перемещаем файлы из временной папки в постоянную
    $TREE->filesDirAction(ROOT . '/downloads/upload_handler/files/thumbnail/', ROOT . '/downloads/images/manufacturers/resize/', $prefix);
    $TREE->filesDirAction(ROOT . '/downloads/upload_handler/files/', ROOT . '/downloads/images/manufacturers/originals/', $prefix);
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    $logo_delete = explode(',', $PDO->selectPrepare("SELECT logo FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [$VALID->inPOST('delete')]), -1);
    foreach ($logo_delete as $file) {
        chmod(ROOT . '/downloads/images/manufacturers/resize/' . $file, 0777);
        chmod(ROOT . '/downloads/images/manufacturers/originals/' . $file, 0777);
        unlink(ROOT . '/downloads/images/manufacturers/resize/' . $file); // Удаляем файлы
        unlink(ROOT . '/downloads/images/manufacturers/originals/' . $file); // Удаляем файлы
    }
    // Удаляем запись
    $PDO->inPrepare("DELETE FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [$VALID->inPOST('delete')]);
}

// Выборочное удаление изображений в модальном окне "Редактировать"
if ($VALID->inPOST('delete_image') && $VALID->inPOST('delete_image_id')) {

    // Новый уникальный префикс для файлов
    $prefix = time() . '_';
    // Получаем массив изображений
    $image_list_arr = explode(',', $PDO->selectPrepare("SELECT logo FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [$VALID->inPOST('delete_image_id')]), -1);
    $image_list_new = '';
    foreach ($image_list_arr as $key => $file) {
        if ($file != $VALID->inPOST('delete_image')) {
            $image_list_new .= $file . ',';
        } else {
            chmod(ROOT . '/downloads/images/manufacturers/resize/' . $file, 0777);
            chmod(ROOT . '/downloads/images/manufacturers/originals/' . $file, 0777);
            unlink(ROOT . '/downloads/images/manufacturers/resize/' . $file); // Удаляем файлы
            unlink(ROOT . '/downloads/images/manufacturers/originals/' . $file); // Удаляем файлы
        }
    }

    for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_MANUFACTURERS . " SET logo=? WHERE id=? AND language=?", [$image_list_new, $VALID->inPOST('delete_image_id'), lang('#lang_all')[$xl]]);
    }
}

// Выборочное удаление изображений в модальном окне "Добавить"
if ($VALID->inPOST('delete_add') == 'ok') {
    chmod(ROOT . '/downloads/upload_handler/files/' . $VALID->inPOST('delete_image'), 0777);
    chmod(ROOT . '/downloads/upload_handler/files/thumbnail/' . $VALID->inPOST('delete_image'), 0777);
    unlink(ROOT . '/downloads/upload_handler/files/' . $VALID->inPOST('delete_image')); // Удаляем файлы
    unlink(ROOT . '/downloads/upload_handler/files/thumbnail/' . $VALID->inPOST('delete_image')); // Удаляем файлы
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