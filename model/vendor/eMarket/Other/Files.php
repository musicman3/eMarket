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

        // Если открываем модальное окно, то очищаются папки временных файлов изображений
        if ($VALID->inPOST('file_upload') == 'empty' OR $VALID->inGET('file_upload') == 'empty') {
            $TREE->filesDirAction(ROOT . '/uploads/temp/originals/');
            $TREE->filesDirAction(ROOT . '/uploads/temp/thumbnail/');
            $TREE->filesDirAction(ROOT . '/uploads/temp/files/');
        }
        // Если нажали на кнопку Добавить
        if (isset($_SESSION['add_image']) && $_SESSION['add_image'] = 'ok') {
            unset($_SESSION['add_image']);
            // Делаем ресайз
            self::imgResize($dir, $files, $prefix, $resize_param);

            // Составляем новый список файлов изображений
            $files = glob(ROOT . '/uploads/temp/originals/*');

            // Получаем последний id и увеличиваем его на 1
            $id_max = $PDO->selectPrepare("SELECT id FROM " . $TABLE . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max);

            $image_list = '';
            foreach ($files as $file) {
                if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                    $image_list .= basename($file) . ',';
                }
            }
            // Назначаем "Главное изображение" в модальном окне "Добавить"
            if ($VALID->inPOST('general_image_add')) {
                $general_image_add = $prefix . $VALID->inPOST('general_image_add');
            } elseif ($VALID->inGET('general_image_add')) {
                $general_image_add = $prefix . $VALID->inGET('general_image_add');
            } else {
                $general_image_add = explode(',', $image_list, -1)[0];
            }
            // Перемещаем оригинальные файлы из временной папки в постоянную
            $TREE->filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

            // Обновляем запись для всех вкладок
            $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list, $general_image_add, $id]);
        }

        // Если нажали на кнопку Редактировать
        if (isset($_SESSION['edit_image']) && $_SESSION['edit_image'] = 'ok') {
            unset($_SESSION['edit_image']);

            if ($VALID->inPOST('edit')) {
                $id = $VALID->inPOST('edit');
            }
            if ($VALID->inGET('edit')) {
                $id = $VALID->inGET('edit');
            }
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

            // Назначаем "Главное изображение" в модальном окне "Редактировать"
            if ($VALID->inPOST('general_image_edit')) {
                $general_image_edit = $VALID->inPOST('general_image_edit');
            }
            if ($VALID->inGET('general_image_edit')) {
                $general_image_edit = $VALID->inGET('general_image_edit');
            }
            // Назначаем "Главное изображение" для нового не сохраненного изображения в модальном окне "Редактировать"
            if ($VALID->inPOST('general_image_edit_new')) {
                $general_image_edit = $prefix . $VALID->inPOST('general_image_edit_new');
            }
            if ($VALID->inGET('general_image_edit_new')) {
                $general_image_edit = $prefix . $VALID->inGET('general_image_edit_new');
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
            if ($VALID->inPOST('delete_image') OR $VALID->inGET('delete_image')) {
                // Получаем массив удаляемых изображений
                if ($VALID->inPOST('delete_image')) {
                    $delete_image_arr = explode(',', $VALID->inPOST('delete_image'), -1);
                }
                if ($VALID->inGET('delete_image')) {
                    $delete_image_arr = explode(',', $VALID->inGET('delete_image'), -1);
                }
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
                            $logo_general_update = 'ok';
                        }
                    }
                }
                if (isset($logo_general_update)) {
                    // Если есть маркер, то устанавливаем новую первую картинку по списку главной
                    $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [$image_list_new, explode(',', $image_list_new, -1)[0], $id]);
                } else {
                    $PDO->inPrepare("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [$image_list_new, $id]);
                }
            }
        }

        // Если нажали на кнопку Удалить
        if ($VALID->inPOST('delete') OR $VALID->inGET('delete')) {
            if ($VALID->inPOST('delete')) {
                $id = $VALID->inPOST('delete');
            }
            if ($VALID->inGET('delete')) {
                $id = $VALID->inGET('delete');
            }
            $logo_delete = explode(',', $PDO->selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), -1);
            foreach ($logo_delete as $file) {
                // Удаляем файлы
                foreach ($resize_param as $key => $value) {
                    $FUNC->deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                }
                $FUNC->deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
            }
        }

        // Выборочное удаление изображений в модальном окне "Добавить"
        if (($VALID->inPOST('delete_new_image') == 'ok' && $VALID->inPOST('delete_image')) OR ( $VALID->inGET('delete_new_image') == 'ok' && $VALID->inGET('delete_image'))) {
            if ($VALID->inPOST('delete_image')) {
                $id = $VALID->inPOST('delete_image');
            }
            if ($VALID->inGET('delete_image')) {
                $id = $VALID->inGET('delete_image');
            }
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
        $resize_max = self::imgResizeMax($resize_param);

        foreach ($files as $file) {
            if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                foreach ($resize_param as $key => $value) {

                    $width = $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . basename($file))->getWidth();
                    $height = $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . basename($file))->getHeight();

                    $quality_width = $resize_max[0];
                    $quality_height = $resize_max[1];

                    if ($width >= $quality_width && $width > $height) {
                        //Копируем выбранный оригинал во временную папку
                        if (!file_exists(ROOT . '/uploads/temp/originals/' . $prefix . basename($file))) {
                            copy(ROOT . '/uploads/temp/files/' . basename($file), ROOT . '/uploads/temp/originals/' . $prefix . basename($file));
                        }
                        $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . basename($file))
                                ->resize($value[0], null) // ширина, высота
                                ->toFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $prefix . basename($file));
                    } elseif ($height >= $quality_height && $height >= $width) {
                        //Копируем выбранный оригинал во временную папку
                        if (!file_exists(ROOT . '/uploads/temp/originals/' . $prefix . basename($file))) {
                            copy(ROOT . '/uploads/temp/files/' . basename($file), ROOT . '/uploads/temp/originals/' . $prefix . basename($file));
                        }
                        $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . basename($file))
                                ->resize(null, $value[1]) // ширина, высота
                                ->toFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $prefix . basename($file));
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
        if ($VALID->inPOST('image_data') OR $VALID->inGET('image_data')) {
            if ($VALID->inPOST('image_data')) {
                $file = $VALID->inPOST('image_data');
            }
            if ($VALID->inGET('image_data')) {
                $file = $VALID->inGET('image_data');
            }
            // Массив с данными по оригинальному изображению
            $image_data = getimagesize(ROOT . '/uploads/temp/files/' . $file);
            // Получаем ширину и высоту изображения
            $width = $image_data[0];
            $height = $image_data[1];
            //Минимальный размер ширины и высоты для качественного ресайза
            $quality_width = $resize_max[0];
            $quality_height = $resize_max[1];

            // Делаем ресайз временной картинки thumbnail
            if ($width >= $quality_width && $width > $height) {
                $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . $file)
                        ->resize($resize_param[0][0], null) // ширина, высота
                        ->toFile(ROOT . '/uploads/temp/thumbnail/' . $file);
            } elseif ($height >= $quality_height && $height >= $width) {
                $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . $file)
                        ->resize(null, $resize_param[0][1]) // ширина, высота
                        ->toFile(ROOT . '/uploads/temp/thumbnail/' . $file);
            }
            // Отправяем данные по изображению в ответ на запрос Ajax
            echo json_encode($image_data);
            exit();
        }
    }

}

?>