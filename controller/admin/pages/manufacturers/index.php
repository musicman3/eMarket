<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */

    // Новый уникальный префикс для файлов
    $prefix = time() . '_';
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

    $image_list = '';
    // Составляем список файлов изображений
    $files = glob(ROOT . '/downloads/upload_handler/files/thumbnail/*');
    foreach ($files as $file) {
        if (is_file($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
            $image_list .= $prefix . basename($file) . ',';
        }
    }
    // Назначаем "Главное изображение" в модальном окне "Добавить"
    if ($VALID->inPOST('general_image_add')) {
        $general_image_add = $prefix . $VALID->inPOST('general_image_add');
    }else{
        $general_image_add = '';
    }
    
    // добавляем запись для всех вкладок
    for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_MANUFACTURERS . " SET id=?, name=?, language=?, logo=?, site=?, logo_general=?", [$id, $VALID->inPOST($SET->titleDir() . '_' . lang('#lang_all')[$xl]), lang('#lang_all')[$xl], $image_list, $VALID->inPOST('site'), $general_image_add]);
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
        // Удаляем файлы
        $FUNC->deleteFile(ROOT . '/downloads/images/manufacturers/resize/' . $file);
        $FUNC->deleteFile(ROOT . '/downloads/images/manufacturers/originals/' . $file);
    }
    // Удаляем запись
    $PDO->inPrepare("DELETE FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [$VALID->inPOST('delete')]);
}

// Выборочное удаление изображений в модальном окне "Редактировать"
if ($VALID->inPOST('delete_image') && $VALID->inPOST('edit')) {
    // Получаем массив удаляемых изображений
    $delete_image_arr = explode(',', $VALID->inPOST('delete_image'), -1);
    // Получаем массив изображений из БД
    $image_list_arr = explode(',', $PDO->selectPrepare("SELECT logo FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [$VALID->inPOST('edit')]), -1);
    $image_list_new = '';
    foreach ($image_list_arr as $key => $file) {
        if (!in_array($file, $delete_image_arr)) {
            $image_list_new .= $file . ',';
        } else {
            // Удаляем файлы
            $FUNC->deleteFile(ROOT . '/downloads/images/manufacturers/resize/' . $file);
            $FUNC->deleteFile(ROOT . '/downloads/images/manufacturers/originals/' . $file);
        }
    }

    for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_MANUFACTURERS . " SET logo=? WHERE id=? AND language=?", [$image_list_new, $VALID->inPOST('edit'), lang('#lang_all')[$xl]]);
    }
}

// Выборочное удаление изображений в модальном окне "Добавить"
if ($VALID->inPOST('delete_new_image') == 'ok' && $VALID->inPOST('delete_image')) {
    // Удаляем файлы
    $FUNC->deleteFile(ROOT . '/downloads/upload_handler/files/' . $VALID->inPOST('delete_image'));
    $FUNC->deleteFile(ROOT . '/downloads/upload_handler/files/thumbnail/' . $VALID->inPOST('delete_image'));
}

// Назначаем "Главное изображение" в модальном окне "Редактировать"
if ($VALID->inPOST('general_image_edit') && $VALID->inPOST('edit')) {
    for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_MANUFACTURERS . " SET logo_general=? WHERE id=? AND language=?", [$VALID->inPOST('general_image_edit'), $VALID->inPOST('edit'), lang('#lang_all')[$xl]]);
    }
}

// Назначаем "Главное изображение" для нового не сохраненного изображения в модальном окне "Редактировать"
if ($VALID->inPOST('general_image_edit_new') && $VALID->inPOST('edit')) {
    for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_MANUFACTURERS . " SET logo_general=? WHERE id=? AND language=?", [$prefix . $VALID->inPOST('general_image_edit_new'), $VALID->inPOST('edit'), lang('#lang_all')[$xl]]);
    }
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