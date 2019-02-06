<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Other;

/**
 * Класс для работы с файлами
 *
 * @package Files
 * @author eMarket
 * 
 */
class Files {

    /**
     * Загрузчик изображений
     *
     * @param string $TABLE (таблица в БД)
     * @param string $dir (директория для загружаемых изображений)
     * @param array $resize_param (параметры ресайза)
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
        $files = glob(ROOT . '/uploads/temp/files/*');
        $count_files = count($files);

        // Если открываем модальное окно, то очищаются папки временных файлов изображений
        if ($VALID->inPOST('file_upload') == 'empty') {
            $TREE->filesDirAction(ROOT . '/uploads/temp/originals/');
            $TREE->filesDirAction(ROOT . '/uploads/temp/thumbnail/');
            $TREE->filesDirAction(ROOT . '/uploads/temp/files/');
        }
        // Если нажали на кнопку Добавить
        if ($VALID->inPOST('add')) {
            // Делаем ресайз
            if ($count_files > 0) {
                self::imgResize($dir, $files, $prefix, $resize_param);
            }

            // Составляем новый список файлов изображений
            $files = glob(ROOT . '/uploads/temp/originals/*');
            $count_files = count($files);
            if ($count_files > 0) {

                // Получаем последний id и увеличиваем его на 1
                $id_max = $PDO->selectPrepare("SELECT id FROM " . $TABLE . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
                $id = intval($id_max);

                $image_list = '';
                foreach ($files as $file) {
                    if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                        $image_list .= basename($file) . ',';
                    }
                }
                // "Главное изображение" по-умолчанию
                if (empty($image_list) == FALSE) {
                    $general_image_add = explode(',', $image_list, -1)[0];
                }
                // Назначаем "Главное изображение" в модальном окне "Добавить"
                if ($VALID->inPOST('general_image_add')) {
                    $general_image_add = $prefix . $VALID->inPOST('general_image_add');
                }
                // Перемещаем оригинальные файлы из временной папки в постоянную
                $TREE->filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

                // Обновляем запись для всех вкладок
                $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list, $general_image_add, $id]);
            }
        }

        // Если нажали на кнопку Редактировать
        if ($VALID->inPOST('edit')) {

            $id = $VALID->inPOST('edit');

            // Делаем ресайз
            self::imgResize($dir, $files, $prefix, $resize_param);

            // Составляем новый список файлов изображений
            $files = glob(ROOT . '/uploads/temp/originals/*');

            $image_list = $PDO->selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]);
            foreach ($files as $file) {
                if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                    $image_list .= basename($file) . ',';
                }
            }
            // "Главное изображение" по-умолчанию
            if (empty($image_list) == FALSE) {
                $general_image_edit = explode(',', $image_list, -1)[0];
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
            $TREE->filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

            // Обновляем запись
            if (isset($general_image_edit)) {
                $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list, $general_image_edit, $id]);
            } else {
                $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [$image_list, $id]);
            }

            // Выборочное удаление изображений в модальном окне "Редактировать"
            if ($VALID->inPOST('delete_image')) {
                // Получаем массив удаляемых изображений
                $delete_image_arr = explode(',', $VALID->inPOST('delete_image'), -1);

                // Получаем массив изображений из БД
                $image_list_arr = explode(',', $PDO->selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), -1);
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
                        if ($file == $PDO->selectPrepare("SELECT logo_general FROM " . $TABLE . " WHERE id=?", [$id])) {
                            $PDO->inPrepare("UPDATE " . $TABLE . " SET logo_general=? WHERE id=?", [NULL, $id]);
                            $logo_general_update = 'ok';
                        }
                    }
                }
                if (isset($logo_general_update) && empty($image_list_new) == FALSE) {
                    // Если есть маркер, то устанавливаем новую первую картинку по списку главной
                    $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list_new, explode(',', $image_list_new, -1)[0], $id]);
                } else {
                    $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [$image_list_new, $id]);
                }
            }
        }

        // Если нажали на кнопку Удалить
        if ($VALID->inPOST('delete')) {
            $idx = $FUNC->deleteEmptyInArray($VALID->inPOST('delete'));

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    $id = $idx[$i];

                    $logo_delete = explode(',', $PDO->selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), -1);
                    if (count($logo_delete) > 0) {
                        foreach ($logo_delete as $file) {
                            // Удаляем файлы
                            foreach ($resize_param as $key => $value) {
                                $FUNC->deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                            }
                            $FUNC->deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
                        }
                    }
                }
            }
        }

        // Выборочное удаление изображений в модальном окне "Добавить"
        if ($VALID->inPOST('delete_new_image') == 'ok' && $VALID->inPOST('delete_image')) {
            $id = $VALID->inPOST('delete_image');

            // Удаляем файлы
            $FUNC->deleteFile(ROOT . '/uploads/temp/files/' . $id);
            $FUNC->deleteFile(ROOT . '/uploads/temp/thumbnail/' . $id);
        }
    }

    /**
     * Загрузчик изображений
     *
     * @param string $TABLE (таблица в БД)
     * @param string $dir (директория для загружаемых изображений)
     * @param array $resize_param (параметры ресайза)
     */
    public function imgUploadProduct($TABLE, $dir, $resize_param) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
        $TREE = new \eMarket\Core\Tree;
        $FUNC = new \eMarket\Other\Func;

        // Если получили запрос на получение данных по изображению
        self::imgThumbAndSize($resize_param);

        // Новый уникальный префикс для файлов
        $prefix = time() . '_';
        // Составляем список файлов изображений
        $files = glob(ROOT . '/uploads/temp/files/*');
        $count_files = count($files);

        // Если открываем модальное окно, то очищаются папки временных файлов изображений
        if ($VALID->inPOST('file_upload') == 'empty') {
            $TREE->filesDirAction(ROOT . '/uploads/temp/originals/');
            $TREE->filesDirAction(ROOT . '/uploads/temp/thumbnail/');
            $TREE->filesDirAction(ROOT . '/uploads/temp/files/');
        }
        // Если нажали на кнопку Добавить
        if ($VALID->inPOST('add_product')) {
            // Делаем ресайз
            if ($count_files > 0) {
                self::imgResize($dir, $files, $prefix, $resize_param);
            }

            // Составляем новый список файлов изображений
            $files = glob(ROOT . '/uploads/temp/originals/*');
            $count_files = count($files);
            if ($count_files > 0) {

                // Получаем последний id
                $id_max = $PDO->selectPrepare("SELECT id FROM " . $TABLE . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
                $id = intval($id_max);

                $image_list = '';
                foreach ($files as $file) {
                    if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                        $image_list .= basename($file) . ',';
                    }
                }
                // "Главное изображение" по-умолчанию
                if (empty($image_list) == FALSE) {
                    $general_image_add = explode(',', $image_list, -1)[0];
                }
                // Назначаем "Главное изображение" в модальном окне "Добавить"
                if ($VALID->inPOST('general_image_add_product')) {
                    $general_image_add = $prefix . $VALID->inPOST('general_image_add_product');
                }
                // Перемещаем оригинальные файлы из временной папки в постоянную
                $TREE->filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

                // Обновляем запись для всех вкладок
                $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list, $general_image_add, $id]);
            }
        }

        // Если нажали на кнопку Редактировать
        if ($VALID->inPOST('edit_product')) {

            $id = $VALID->inPOST('edit_product');

            // Делаем ресайз
            self::imgResize($dir, $files, $prefix, $resize_param);

            // Составляем новый список файлов изображений
            $files = glob(ROOT . '/uploads/temp/originals/*');

            $image_list = $PDO->selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]);
            foreach ($files as $file) {
                if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                    $image_list .= basename($file) . ',';
                }
            }
            // "Главное изображение" по-умолчанию
            if (empty($image_list) == FALSE) {
                $general_image_edit = explode(',', $image_list, -1)[0];
            }
            // Назначаем "Главное изображение" в модальном окне "Редактировать"
            if ($VALID->inPOST('general_image_edit_product')) {
                $general_image_edit = $VALID->inPOST('general_image_edit_product');
            }
            // Назначаем "Главное изображение" для нового не сохраненного изображения в модальном окне "Редактировать"
            if ($VALID->inPOST('general_image_edit_new_product')) {
                $general_image_edit = $prefix . $VALID->inPOST('general_image_edit_new_product');
            }

            // Перемещаем оригинальные файлы из временной папки в постоянную
            $TREE->filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

            // Обновляем запись
            if (isset($general_image_edit)) {
                $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list, $general_image_edit, $id]);
            } else {
                $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [$image_list, $id]);
            }

            // Выборочное удаление изображений в модальном окне "Редактировать"
            if ($VALID->inPOST('delete_image_product')) {
                // Получаем массив удаляемых изображений
                $delete_image_arr = explode(',', $VALID->inPOST('delete_image_product'), -1);

                // Получаем массив изображений из БД
                $image_list_arr = explode(',', $PDO->selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), -1);
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
                        if ($file == $PDO->selectPrepare("SELECT logo_general FROM " . $TABLE . " WHERE id=?", [$id])) {
                            $PDO->inPrepare("UPDATE " . $TABLE . " SET logo_general=? WHERE id=?", [NULL, $id]);
                            $logo_general_update = 'ok';
                        }
                    }
                }
                if (isset($logo_general_update) && empty($image_list_new) == FALSE) {
                    // Если есть маркер, то устанавливаем новую первую картинку по списку главной
                    $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list_new, explode(',', $image_list_new, -1)[0], $id]);
                } else {
                    $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [$image_list_new, $id]);
                }
            }
        }

        // Если нажали на кнопку Удалить
        if ($VALID->inPOST('delete')) {
            $idx = $FUNC->deleteEmptyInArray($VALID->inPOST('delete'));

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) == 'product') {
                    // Это товар
                    $id = explode('product_', $idx[$i]);

                    $logo_delete = explode(',', $PDO->selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id[1]]), -1);
                    if (count($logo_delete) > 0) {
                        foreach ($logo_delete as $file) {
                            // Удаляем файлы
                            foreach ($resize_param as $key => $value) {
                                $FUNC->deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                            }
                            $FUNC->deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
                        }
                    }
                }
            }
        }

        // Выборочное удаление изображений в модальном окне "Добавить"
        if ($VALID->inPOST('delete_new_image_product') == 'ok' && $VALID->inPOST('delete_image_product')) {
            $id = $VALID->inPOST('delete_image_product');

            // Удаляем файлы
            $FUNC->deleteFile(ROOT . '/uploads/temp/files/' . $id);
            $FUNC->deleteFile(ROOT . '/uploads/temp/thumbnail/' . $id);
        }
    }

    /**
     * Ресайз изображений
     *
     * @param string $dir директория для загружаемых изображений)
     * @param array $files (массив с загружаемыми файлами)
     * @param string $prefix (префикс к названию файлов)
     * @param array $resize_param (параметры ресайза)
     */
    public function imgResize($dir, $files, $prefix, $resize_param) {

        // Делаем ресайз
        $IMAGE = new \claviska\SimpleImage;
        $FUNC = new \eMarket\Other\Func;
        $VALID = new \eMarket\Core\Valid;
        $resize_max = self::imgResizeMax($resize_param);

        foreach ($files as $file) {
            if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                foreach ($resize_param as $key => $value) {

                    $width = $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . basename($file))->getWidth();
                    $height = $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . basename($file))->getHeight();

                    $quality_width = $resize_max[0];
                    $quality_height = $resize_max[1];

                    if ($width >= $quality_width OR $height >= $quality_height) {
                        //Копируем выбранный оригинал во временную папку
                        if (!file_exists(ROOT . '/uploads/temp/originals/' . $prefix . basename($file))) {
                            copy(ROOT . '/uploads/temp/files/' . basename($file), ROOT . '/uploads/temp/originals/' . $prefix . basename($file));
                        }
                        $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . basename($file))
                                ->autoOrient()
                                ->bestFit($value[0], $value[1]); // ширина, высота
                        if ($VALID->inPOST('effect-edit-product') == 'effect-sepia' OR $VALID->inPOST('effect-add-product') == 'effect-sepia') {
                            $IMAGE->sepia();
                        }
                        if ($VALID->inPOST('effect-edit-product') == 'effect-black-white' OR $VALID->inPOST('effect-add-product') == 'effect-black-white') {
                            $IMAGE->desaturate();
                        }
                        $IMAGE->toFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $prefix . basename($file));
                    }
                }
                // Удаляем временные файлы
                $FUNC->deleteFile(ROOT . '/uploads/temp/thumbnail/' . basename($file));
                $FUNC->deleteFile(ROOT . '/uploads/temp/files/' . basename($file));
            }
        }
    }

    /**
     * Массив максимальных размеров изображения после ресайза
     *
     * @param array $resize_param (параметры ресайза)
     * @return array $resize_max (параметры ресайза для максимального качества)
     */
    public function imgResizeMax($resize_param) {

        $count_image_max = count($resize_param);
        $resize_max = [];
        array_push($resize_max, [$resize_param[$count_image_max - 1][0], $resize_param[$count_image_max - 1][1]]);
        return $resize_max[0];
    }

    /**
     * Функция нарезки thumbnail и получения размера изображения по запросу Ajax
     *
     * @param array $resize_param (параметры ресайза)
     */
    public function imgThumbAndSize($resize_param) {

        $VALID = new \eMarket\Core\Valid;
        $IMAGE = new \claviska\SimpleImage;
        $resize_max = self::imgResizeMax($resize_param);

        // Если получили запрос на получение данных по изображению
        if ($VALID->inPOST('image_data')) {
            $file = $VALID->inPOST('image_data');

            // Массив с данными по оригинальному изображению
            $image_data = getimagesize(ROOT . '/uploads/temp/files/' . $file);
            // Получаем ширину и высоту изображения
            $width = $image_data[0];
            $height = $image_data[1];
            //Минимальный размер ширины и высоты для качественного ресайза
            $quality_width = $resize_max[0];
            $quality_height = $resize_max[1];

            // Делаем ресайз временной картинки thumbnail
            if ($width >= $quality_width OR $height >= $quality_height) {
                $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . $file)
                        ->autoOrient()
                        ->bestFit($resize_param[0][0], $resize_param[0][1]); // ширина, высота
                if ($VALID->inPOST('effect_edit') == 'effect-sepia' OR $VALID->inPOST('effect_add') == 'effect-sepia') {
                    $IMAGE->sepia();
                }
                if ($VALID->inPOST('effect_edit') == 'effect-black-white' OR $VALID->inPOST('effect_add') == 'effect-black-white') {
                    $IMAGE->desaturate();
                }
                $IMAGE->toFile(ROOT . '/uploads/temp/thumbnail/' . $file);
            }
            // Отправяем данные по изображению в ответ на запрос Ajax
            echo json_encode($image_data);
            exit();
        }
    }

}

?>