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
     * @param массив $resize_param
     */
    public function imgUpload($TABLE, $dir, $resize_param) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
        $TREE = new \eMarket\Core\Tree;
        $FUNC = new \eMarket\Other\Func;

        // Если получили запрос на получение данных по изображению
        self::imgThumbAndSize($resize_param);

        // Новый уникальный префикс для файлов
        $prefix = time() . '_';
        // Составляем список файлов изображений
        $files = glob(ROOT . '/uploads/upload_handler/files/*');

        // Если открываем модальное окно, то очищаются папки временных файлов изображений
        if ($VALID->inPOST('file_upload') == 'empty') {
            $TREE->filesDirAction(ROOT . '/uploads/upload_handler/files/');
            $TREE->filesDirAction(ROOT . '/uploads/upload_handler/files/thumbnail/');
            $TREE->filesDirAction(ROOT . '/uploads/images/temp/thumbnail/');
        }
        // Если нажали на кнопку Добавить
        if ($VALID->inPOST('add')) {

            // Делаем ресайз
            self::imgResize($dir, $files, $prefix, $resize_param);

            // Составляем новый список файлов изображений
            $files = glob(ROOT . '/uploads/images/temp/*');

            // Получаем последний id и увеличиваем его на 1
            $id_max = $PDO->selectPrepare("SELECT id FROM " . $TABLE . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max);

            $image_list = '';
            foreach ($files as $file) {
                if (is_file($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                    $image_list .= basename($file) . ',';
                }
            }
            // Назначаем "Главное изображение" в модальном окне "Добавить"
            if ($VALID->inPOST('general_image_add')) {
                $general_image_add = $prefix . $VALID->inPOST('general_image_add');
            } else {
                $general_image_add = explode(',', $image_list, -1)[0];
            }

            // Перемещаем оригинальные файлы из временной папки в постоянную
            $TREE->filesDirAction(ROOT . '/uploads/images/temp/', ROOT . '/uploads/images/' . $dir . '/originals/');

            // Обновляем запись для всех вкладок
            $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list, $general_image_add, $id]);
        }

        // Если нажали на кнопку Редактировать
        if ($VALID->inPOST('edit')) {

            // Делаем ресайз
            self::imgResize($dir, $files, $prefix, $resize_param);

            // Составляем новый список файлов изображений
            $files = glob(ROOT . '/uploads/images/temp/*');

            $image_list = $PDO->selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$VALID->inPOST('edit')]);
            foreach ($files as $file) {
                if (is_file($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                    $image_list .= basename($file) . ',';
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

            // Перемещаем оригинальные файлы из временной папки в постоянную
            $TREE->filesDirAction(ROOT . '/uploads/images/temp/', ROOT . '/uploads/images/' . $dir . '/originals/');

            // Обновляем запись
            if (isset($general_image_edit)) {
                $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list, $general_image_edit, $VALID->inPOST('edit')]);
            } else {
                $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [$image_list, $VALID->inPOST('edit')]);
            }

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
                        foreach ($resize_param as $key => $value) {
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
                foreach ($resize_param as $key => $value) {
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

    /**
     * Ресайз изображений
     *
     * @param массив $dir
     * @param строка $files
     * @param строка $prefix
     * @param массив $resize_param
     */
    public function imgResize($dir, $files, $prefix, $resize_param) {

        // Делаем ресайз
        $IMAGE = new \claviska\SimpleImage;
        $FUNC = new \eMarket\Other\Func;

        foreach ($files as $file) {
            if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                foreach ($resize_param as $key => $value) {

                    $width = $IMAGE->fromFile(ROOT . '/uploads/upload_handler/files/' . basename($file))->getWidth();
                    $height = $IMAGE->fromFile(ROOT . '/uploads/upload_handler/files/' . basename($file))->getHeight();

                    if ($width >= $value[1] && $width > $height) {
                        //Копируем выбранный оригинал во временную папку
                        if (!file_exists(ROOT . '/uploads/images/temp/' . $prefix . basename($file))) {
                            copy(ROOT . '/uploads/upload_handler/files/' . basename($file), ROOT . '/uploads/images/temp/' . $prefix . basename($file));
                        }
                        $IMAGE->fromFile(ROOT . '/uploads/upload_handler/files/' . basename($file))
                                ->resize($value[0], null) // ширина, высота
                                ->toFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $prefix . basename($file));
                    } elseif ($width >= $value[1] OR $height >= $value[0]) {
                        //Копируем выбранный оригинал во временную папку
                        if (!file_exists(ROOT . '/uploads/images/temp/' . $prefix . basename($file))) {
                            copy(ROOT . '/uploads/upload_handler/files/' . basename($file), ROOT . '/uploads/images/temp/' . $prefix . basename($file));
                        }
                        $IMAGE->fromFile(ROOT . '/uploads/upload_handler/files/' . basename($file))
                                ->resize(null, $value[1]) // ширина, высота
                                ->toFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $prefix . basename($file));
                    }
                }
                // Удаляем временные файлы в files
                $FUNC->deleteFile(ROOT . '/uploads/upload_handler/files/' . basename($file));
            }
        }
    }

    /**
     * Массив максимальных размеров изображения после ресайза
     *
     * @param массив $resize_param
     * @return массив $resize_max
     */
    public function imgResizeMax($resize_param) {

        $count_image_max = count($resize_param);
        $resize_max = [];
        array_push($resize_max, [$resize_param[$count_image_max - 1][0], $resize_param[$count_image_max - 1][1]]);
        return $resize_max;
    }

    /**
     * Функция нарезки thumbnail и получения размера изображения по запросу Ajax
     *
     * @param массив $resize_param
     * @echo массив $image_data
     */
    public function imgThumbAndSize($resize_param) {

        $VALID = new \eMarket\Core\Valid;
        $IMAGE = new \claviska\SimpleImage;

        // Если получили запрос на получение данных по изображению
        if ($VALID->inPOST('image_data')) {

            $file = $VALID->inPOST('image_data');

            // Массив с данными по оригинальному изображению
            $image_data = getimagesize(ROOT . '/uploads/upload_handler/files/' . $file);
            // Получаем ширину и высоту изображения
            $width = $image_data[0];
            $height = $image_data[1];

            // Делаем ресайз временной картинки thumbnail
            if ($width >= $resize_param[0][1] && $width > $height) {
                $IMAGE->fromFile(ROOT . '/uploads/upload_handler/files/' . $file)
                        ->resize($resize_param[0][0], null) // ширина, высота
                        ->toFile(ROOT . '/uploads/images/temp/thumbnail/' . $file);
            } elseif ($width >= $resize_param[0][1] OR $height >= $resize_param[0][0]) {
                $IMAGE->fromFile(ROOT . '/uploads/upload_handler/files/' . $file)
                        ->resize(null, $resize_param[0][1]) // ширина, высота
                        ->toFile(ROOT . '/uploads/images/temp/thumbnail/' . $file);
            }
            // Отправяем данные по изображению в ответ на запрос Ajax
            echo json_encode($image_data);
            exit();
        }
    }

}

?>