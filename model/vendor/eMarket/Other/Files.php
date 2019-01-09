<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Other;

class Files {

    /**
     * Загрузчик изображений
     *
     * @param строка $TABLE
     * @param строка $dir
     * @param строка $image_max_y = ['94', '150', '244', '394', '638']; пропорционально X= 125, 200, 325, 525, 850
     */
    public function imgUpload($TABLE, $dir, $image_max_y) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
        $TREE = new \eMarket\Core\Tree;
        $FUNC = new \eMarket\Other\Func;

        // Новый уникальный префикс для файлов
        $prefix = time() . '_';
        // Составляем список файлов изображений
        $files = glob(ROOT . '/uploads/upload_handler/files/*');

        // Если открываем модальное окно, то очищаются папки временных файлов изображений
        if ($VALID->inPOST('file_upload') == 'empty') {
            $TREE->filesDirAction(ROOT . '/uploads/upload_handler/files/');
            $TREE->filesDirAction(ROOT . '/uploads/upload_handler/files/thumbnail/');
        }
        // Если нажали на кнопку Добавить
        if ($VALID->inPOST('add')) {

            // Получаем последний id и увеличиваем его на 1
            $id_max = $PDO->selectPrepare("SELECT id FROM " . $TABLE . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max);

            $image_list = '';
            foreach ($files as $file) {
                if (is_file($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                    $image_list .= $prefix . basename($file) . ',';
                }
            }
            // Назначаем "Главное изображение" в модальном окне "Добавить"
            if ($VALID->inPOST('general_image_add')) {
                $general_image_add = $prefix . $VALID->inPOST('general_image_add');
            } else {
                $general_image_add = explode(',', $image_list, -1)[0];
            }

            // Обновляем запись для всех вкладок
            $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list, $general_image_add, $id]);

            // Делаем ресайз
            self::imgResize($dir, $files, $prefix, $image_max_y);
        }

        // Если нажали на кнопку Редактировать
        if ($VALID->inPOST('edit')) {

            $image_list = $PDO->selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$VALID->inPOST('edit')]);
            foreach ($files as $file) {
                if (is_file($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                    $image_list .= $prefix . basename($file) . ',';
                }
            }

            // Назначаем "Главное изображение" в модальном окне "Редактировать"
            if ($VALID->inPOST('general_image_edit')) {
                $general_image_edit = $VALID->inPOST('general_image_edit');
            }
            // Назначаем "Главное изображение" для нового не сохраненного изображения в модальном окне "Редактировать"
            if ($VALID->inPOST('general_image_edit_new')) {
                $general_image_edit = $prefix . $VALID->inPOST('general_image_edit_new');
            }

            // Обновляем запись
            if (isset($general_image_edit)) {
                $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list, $general_image_edit, $VALID->inPOST('edit')]);
            } else {
                $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [$image_list, $VALID->inPOST('edit')]);
            }

            // Делаем ресайз
            self::imgResize($dir, $files, $prefix, $image_max_y);

            // Выборочное удаление изображений в модальном окне "Редактировать"
            if ($VALID->inPOST('delete_image')) {
                // Получаем массив удаляемых изображений
                $delete_image_arr = explode(',', $VALID->inPOST('delete_image'), -1);
                // Получаем массив изображений из БД
                $image_list_arr = explode(',', $PDO->selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$VALID->inPOST('edit')]), -1);
                $image_list_new = '';
                foreach ($image_list_arr as $key => $file) {
                    if (!in_array($file, $delete_image_arr)) {
                        $image_list_new .= $file . ',';
                    } else {
                        // Удаляем файлы
                        foreach ($image_max_y as $key => $value) {
                            $FUNC->deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                        }
                        $FUNC->deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
                        // Если удаляемая картинка является главной, то устанавливаем маркер
                        if ($file == $PDO->selectPrepare("SELECT logo_general FROM " . $TABLE . " WHERE id=?", [$VALID->inPOST('edit')])) {
                            $logo_general_update = 'ok';
                        }
                    }
                }
                if (isset($logo_general_update)) {
                    // Если есть маркер, то устанавливаем новую первую картинку по списку главной
                    $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list_new, explode(',', $image_list_new, -1)[0], $VALID->inPOST('edit')]);
                } else {
                    $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [$image_list_new, $VALID->inPOST('edit')]);
                }
            }
        }

        // Если нажали на кнопку Удалить
        if ($VALID->inPOST('delete')) {
            $logo_delete = explode(',', $PDO->selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$VALID->inPOST('delete')]), -1);
            foreach ($logo_delete as $file) {
                // Удаляем файлы
                foreach ($image_max_y as $key => $value) {
                    $FUNC->deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                }
                $FUNC->deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
            }
        }

        // Выборочное удаление изображений в модальном окне "Добавить"
        if ($VALID->inPOST('delete_new_image') == 'ok' && $VALID->inPOST('delete_image')) {
            // Удаляем файлы
            $FUNC->deleteFile(ROOT . '/uploads/upload_handler/files/' . $VALID->inPOST('delete_image'));
            $FUNC->deleteFile(ROOT . '/uploads/upload_handler/files/thumbnail/' . $VALID->inPOST('delete_image'));
        }
    }

    public function imgResize($dir, $files, $prefix, $image_max_y) {

        // Делаем ресайз
        $IMAGE = new \claviska\SimpleImage;
        $FUNC = new \eMarket\Other\Func;
        $TREE = new \eMarket\Core\Tree;

        foreach ($files as $file) {
            if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                foreach ($image_max_y as $key => $value) {
                    $IMAGE->fromFile(ROOT . '/uploads/upload_handler/files/' . basename($file))
                            ->resize(null, $value) // ширина, высота
                            ->toFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $prefix . basename($file));
                }
                // Удаляем временные файлы в thumbnail
                $FUNC->deleteFile(ROOT . '/uploads/upload_handler/files/thumbnail/' . basename($file));
            }
        }
        // Перемещаем оригинальные файлы из временной папки в постоянную
        $TREE->filesDirAction(ROOT . '/uploads/upload_handler/files/', ROOT . '/uploads/images/' . $dir . '/originals/', $prefix);
    }

}

?>