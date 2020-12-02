<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Движок EAC (Easy Ajax Catalog) v.1.01
 *
 * @package Eac
 * @author eMarket
 * 
 */
final class Eac {

    /**
     * Инициализация EAC
     * @param array $TABLES (названия таблиц)
     * @param array $resize_param (параметры ресайза)
     * @param array $resize_param_product (параметры ресайза фото товаров)
     * @return array [$idsx_real_parent_id, $parent_id]
     */
    public static function init($TABLES, $resize_param, $resize_param_product) {

        // Устанавливаем parent_id родительской категории
        $parent_id = self::parentIdStart($TABLES[0]);

        // Если нажали на кнопку Добавить
        self::addCategory($TABLES[0], $parent_id);

        // Если нажали на кнопку Редактировать
        self::editCategory($TABLES[0]);

        // Если нажали на кнопку Добавить Товар
        self::addProduct($TABLES, $parent_id);

        // Если нажали на кнопку Редактировать товар
        self::editProduct($TABLES, $parent_id);

        // Загручик изображений категорий (ВСТАВЛЯТЬ ПЕРЕД УДАЛЕНИЕМ)
        \eMarket\Files::imgUpload($TABLES[0], 'categories', $resize_param);

        // Загручик изображений товаров (ВСТАВЛЯТЬ ПЕРЕД УДАЛЕНИЕМ)
        \eMarket\Files::imgUploadProduct($TABLES[1], 'products', $resize_param_product);

        $idsx_real_parent_id = $parent_id; //для отправки в JS
        // Если нажали на кнопку Удалить
        $parent_id_delete = self::delete($TABLES[0], $TABLES[1], $parent_id);

        // Если нажали на кнопку Вырезать
        $parent_id_cut = self::cut($TABLES[0], $parent_id);

        // Если нажали на кнопку Вставить
        $parent_id_paste = self::paste($TABLES[0], $TABLES[1], $parent_id);

        // Если нажали на кнопку Скрыть/Отобразить
        $parent_id_status = self::status($TABLES[0], $TABLES[1], $parent_id);

        // Если нажали на кнопку Распродажа
        $parent_id_sale = self::sale($TABLES[0], $TABLES[1], $parent_id);
        
        // Если нажали на кнопку Распродажа
        $parent_id_stiker = self::stiker($TABLES[0], $TABLES[1], $parent_id);

        // Сортировка мышкой EAC
        self::sortList($TABLES[0]);

        if ($parent_id_delete != $parent_id) {
            $parent_id = $parent_id_delete;
        }

        if ($parent_id_cut != $parent_id) {
            $parent_id = $parent_id_cut;
        }

        if ($parent_id_paste != $parent_id) {
            $parent_id = $parent_id_paste;
        }

        if ($parent_id_status != $parent_id) {
            $parent_id = $parent_id_status;
        }

        if ($parent_id_sale != $parent_id) {
            $parent_id = $parent_id_sale;
        }
        
        if ($parent_id_stiker != $parent_id) {
            $parent_id = $parent_id_stiker;
        }

        return [$idsx_real_parent_id, $parent_id];
    }

    /**
     * Первоначальная установка parent_id родительской категории
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private static function parentIdStart($TABLE_CATEGORIES) {

        // Устанавливаем родительскую категорию
        $parent_id = \eMarket\Valid::inPOST('parent_id');
        if ($parent_id == FALSE) {
            $parent_id = 0;
        }

        // Устанавливаем родительскую категорию при переходе на уровень выше
        if (\eMarket\Valid::inGET('parent_up')) {
            $parent_id = \eMarket\Pdo::selectPrepare("SELECT parent_id FROM " . $TABLE_CATEGORIES . " WHERE id=?", [\eMarket\Valid::inGET('parent_up')]);
        }

        // Устанавливаем родительскую категорию при переходе на уровень ниже
        if (\eMarket\Valid::inGET('parent_down')) {
            $parent_id = \eMarket\Valid::inGET('parent_down');
        }

        // Устанавливаем родительскую категорию при навигации ВЛЕВО/ВПРАВО
        if (\eMarket\Valid::inGET('parent_id_temp')) {
            $parent_id = \eMarket\Valid::inGET('parent_id_temp');
        }

        return $parent_id;
    }

    /**
     * Сортировка мышкой в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     */
    private static function sortList($TABLE_CATEGORIES) {

        // если сортируем категории мышкой
        if (\eMarket\Valid::inPOST('ids')) {
            $sort_array_id_ajax = explode(',', \eMarket\Valid::inPOST('ids')); // Массив со списком id под сортировку
            // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
            $sort_array_id = \eMarket\Func::deleteEmptyInArray($sort_array_id_ajax);

            $sort_array_category = []; // Массив со списком sort_category под сортировку

            foreach ($sort_array_id as $val) {
                $sort_category = \eMarket\Pdo::selectPrepare("SELECT sort_category FROM " . $TABLE_CATEGORIES . " WHERE id=? AND language=? ORDER BY id ASC", [$val, lang('#lang_all')[0]]);
                array_push($sort_array_category, $sort_category); // Добавляем данные в массив sort_category
                arsort($sort_array_category); // Сортируем массив со списком sort_category
            }
            // Создаем финальный массив из двух массивов
            $sort_array_final = array_combine($sort_array_id, $sort_array_category);

            foreach ($sort_array_id as $val) {
                \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET sort_category=? WHERE id=?", [(int) $sort_array_final[$val], (int) $val]);
            }
        }
    }

    /**
     * Добавить категорию в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $parent_id (идентификатор родительской категории)
     */
    private static function addCategory($TABLE_CATEGORIES, $parent_id) {

        $LANG_COUNT = count(lang('#lang_all'));

        if (\eMarket\Valid::inPOST('add')) {

            // Получаем последний sort_category в текущем parent_id и увеличиваем его на 1
            $sort_max = \eMarket\Pdo::selectPrepare("SELECT sort_category FROM " . $TABLE_CATEGORIES . " WHERE language=? AND parent_id=? ORDER BY sort_category DESC", [lang('#lang_all')[0], $parent_id]);
            $sort_category = intval($sort_max) + 1;

            // Получаем последний id и увеличиваем его на 1
            $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_CATEGORIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if (\eMarket\Valid::inPOST('attributes')) {
                $attributes = \eMarket\Valid::inPOST('attributes');
            } else {
                $attributes = json_encode([]);
            }

            // добавляем запись для всех вкладок
            for ($x = 0; $x < $LANG_COUNT; $x++) {
                \eMarket\Pdo::inPrepare("INSERT INTO " . $TABLE_CATEGORIES . " SET id=?, name=?, sort_category=?, language=?, parent_id=?, date_added=?, status=?, logo=?, attributes=?", [$id, \eMarket\Valid::inPOST('name_categories_stock_' . $x), $sort_category, lang('#lang_all')[$x], $parent_id, date("Y-m-d H:i:s"), 1, json_encode([]), $attributes]);
            }
            // Выводим сообщение об успехе
            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Редактировать категорию в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     */
    private static function editCategory($TABLE_CATEGORIES) {

        $LANG_COUNT = count(lang('#lang_all'));

        if (\eMarket\Valid::inPOST('edit')) {

            for ($x = 0; $x < $LANG_COUNT; $x++) {
                // обновляем запись
                \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET name=?, last_modified=?, attributes=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_categories_stock_' . $x), date("Y-m-d H:i:s"), \eMarket\Valid::inPOST('attributes'), \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
            }
            // Выводим сообщение об успехе
            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Удаляем категорию в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $TABLE_PRODUCTS (название таблицы товаров)
     * @param string $parent_id (идентификатор родительской категории)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private static function delete($TABLE_CATEGORIES, $TABLE_PRODUCTS, $parent_id) {

        if (\eMarket\Valid::inPOST('delete')) {

            // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
            $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('delete'));

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    // Это категория
                    $parent_id = self::dataParentId($TABLE_CATEGORIES, $idx[$i]);
                    $keys = self::dataKeys($TABLE_CATEGORIES, $idx[$i]);

                    $count_keys = count($keys); // Получаем количество значений в массиве
                    for ($x = 0; $x < $count_keys; $x++) {

                        //Удаляем товар  
                        \eMarket\Pdo::inPrepare("DELETE FROM " . $TABLE_PRODUCTS . " WHERE parent_id=?", [$keys[$x]]);

                        //Удаляем подкатегории
                        \eMarket\Pdo::inPrepare("DELETE FROM " . $TABLE_CATEGORIES . " WHERE parent_id=?", [$keys[$x]]);
                    }

                    //Удаляем основную категорию    
                    \eMarket\Pdo::inPrepare("DELETE FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$idx[$i]]);

                    //Удаляем из буффера, если есть
                    if (isset($_SESSION['buffer']['cat']) && $_SESSION['buffer']['cat'] != FALSE) {
                        $_SESSION['buffer']['cat'] = \eMarket\Func::deleteValInArray($_SESSION['buffer']['cat'], [$idx[$i]]);
                        if (count($_SESSION['buffer']['cat']) == 0) {
                            unset($_SESSION['buffer']['cat']);
                        }
                    }
                } else {
                    // Это товар
                    $id_prod = explode('product_', $idx[$i]);
                    //Удаляем основной товар
                    \eMarket\Pdo::inPrepare("DELETE FROM " . $TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);

                    //Удаляем из буффера, если есть
                    if (isset($_SESSION['buffer']['prod']) && $_SESSION['buffer']['prod'] != FALSE) {
                        $_SESSION['buffer']['prod'] = \eMarket\Func::deleteValInArray($_SESSION['buffer']['prod'], [$id_prod[1]]);
                        if (count($_SESSION['buffer']['prod']) == 0) {
                            unset($_SESSION['buffer']['prod']);
                        }
                    }
                }
                // Выводим сообщение об успехе
                \eMarket\Messages::alert('success', lang('action_completed_successfully'));
            }
        }

        // Если parrent_id является массивом, то
        if (is_array($parent_id) == TRUE) {
            $parent_id = 0;
        }

        return $parent_id;
    }

    /**
     * Вырезаем категорию в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $parent_id (идентификатор родительской категории)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private static function cut($TABLE_CATEGORIES, $parent_id) {

        if (\eMarket\Valid::inPOST('idsx_cut_marker') == 'cut') { // очищаем буфер обмена, если он был заполнен, при нажатии Вырезать
            unset($_SESSION['buffer']);
        }

        if ((\eMarket\Valid::inPOST('idsx_cut_key') == 'cut')) {
            // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
            $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_cut_id'));

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {

                $parent_id_real = (int) \eMarket\Valid::inPOST('idsx_real_parent_id'); // получить значение из JS
                $parent_id = self::dataParentId($TABLE_CATEGORIES, $idx[$i]);

                //Вырезаем основную родительскую категорию    
                if (\eMarket\Valid::inPOST('idsx_cut_key') == 'cut') {
                    // Это категория
                    if (strstr($idx[$i], '_', true) != 'product') {
                        if (!isset($_SESSION['buffer']['cat'])) {
                            $_SESSION['buffer']['cat'] = [];
                        }
                        array_push($_SESSION['buffer']['cat'], $idx[$i]);
                        if ($parent_id_real > 0) {
                            $parent_id = $parent_id_real; // Возвращаемся в свою директорию после обновления
                        }
                    } else {
                        // Это товар
                        if (!isset($_SESSION['buffer']['prod'])) {
                            $_SESSION['buffer']['prod'] = [];
                        }
                        $id_prod = explode('product_', $idx[$i]);
                        array_push($_SESSION['buffer']['prod'], $id_prod[1]);
                        if ($parent_id_real > 0) {
                            $parent_id = $parent_id_real; // Возвращаемся в свою директорию после обновления
                        }
                    }
                }
            }
        }

        // Если parrent_id является массивом, то
        if (is_array($parent_id) == TRUE) {
            $parent_id = 0;
        }

        return $parent_id;
    }

    /**
     * Вставляем категорию в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $TABLE_PRODUCTS (название таблицы товаров)
     * @param string $parent_id (идентификатор родительской категории)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private static function paste($TABLE_CATEGORIES, $TABLE_PRODUCTS, $parent_id) {

        //Вставляем вырезанные категории    
        if (\eMarket\Valid::inPOST('idsx_paste_key') == 'paste' && isset($_SESSION['buffer']) == TRUE) {

            $parent_id_real = (int) \eMarket\Valid::inPOST('idsx_real_parent_id'); // получить значение из JS
            if (isset($_SESSION['buffer']['cat'])) {
                $count_session_buffer_cat = count($_SESSION['buffer']['cat']);
            } else {
                $count_session_buffer_cat = 0;
            }
            if (isset($_SESSION['buffer']['prod'])) {
                $count_session_buffer_prod = count($_SESSION['buffer']['prod']);
            } else {
                $count_session_buffer_prod = 0;
            }

            $count_session_buffer = $count_session_buffer_cat + $count_session_buffer_prod; // Получаем количество значений в массиве

            for ($buf = 0; $buf < $count_session_buffer; $buf++) {
                // Это категория
                if (isset($_SESSION['buffer']['cat'][$buf]) && count($_SESSION['buffer']['cat']) > 0) {
                    // Получаем последний sort_category в текущем parent_id и увеличиваем его на 1
                    $sort_max = \eMarket\Pdo::selectPrepare("SELECT sort_category FROM " . $TABLE_CATEGORIES . " WHERE language=? AND parent_id=? ORDER BY sort_category DESC", [lang('#lang_all')[0], $parent_id_real]);
                    $sort_category = intval($sort_max) + 1;
                    // Обновляем данные
                    \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET parent_id=?, sort_category=? WHERE id=?", [$parent_id_real, $sort_category, $_SESSION['buffer']['cat'][$buf]]);
                }

                if (isset($_SESSION['buffer']['prod'][$buf]) && count($_SESSION['buffer']['prod']) > 0) {
                    // Это товар
                    // Обновляем данные
                    \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET parent_id=?, attributes=? WHERE id=?", [$parent_id_real, json_encode([]), $_SESSION['buffer']['prod'][$buf]]);
                }
            }
            unset($_SESSION['buffer']); // очищаем буфер обмена
            if ($parent_id_real > 0) {
                $parent_id = $parent_id_real; // Возвращаемся в свою директорию после вставки
            }
            // Выводим сообщение об успехе
            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
        // Если parrent_id является массивом, то
        if (is_array($parent_id) == TRUE) {
            $parent_id = 0;
        }

        return $parent_id;
    }

    /**
     * Статус категорий в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $TABLE_PRODUCTS (название таблицы товаров)
     * @param string $parent_id (идентификатор родительской категории)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private static function status($TABLE_CATEGORIES, $TABLE_PRODUCTS, $parent_id) {

        if ((\eMarket\Valid::inPOST('idsx_statusOn_key') == 'On')
                or ( \eMarket\Valid::inPOST('idsx_statusOff_key') == 'Off')) {

            $parent_id_real = (int) \eMarket\Valid::inPOST('idsx_real_parent_id'); // получить значение из JS

            if (\eMarket\Valid::inPOST('idsx_statusOn_key') == 'On') {
                // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_statusOn_id'));
                $status = 1;
            }

            if (\eMarket\Valid::inPOST('idsx_statusOff_key') == 'Off') {
                // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_statusOff_id'));
                $status = 0;
            }

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    // Это категория
                    $parent_id = self::dataParentId($TABLE_CATEGORIES, $idx[$i]);
                    $keys = self::dataKeys($TABLE_CATEGORIES, $idx[$i]);

                    $count_keys = count($keys); // Получаем количество значений в массиве
                    for ($x = 0; $x < $count_keys; $x++) {

                        //Обновляем статус подкатегорий
                        if ((\eMarket\Valid::inPOST('idsx_statusOn_key') == 'On')
                                or ( \eMarket\Valid::inPOST('idsx_statusOff_key') == 'Off')) {

                            // Это категория
                            \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET status=? WHERE parent_id=?", [$status, $keys[$x]]);

                            // Это товар
                            \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET status=? WHERE parent_id=?", [$status, $keys[$x]]);

                            if ($parent_id_real > 0) {
                                $parent_id = $parent_id_real; // Возвращаемся в свою директорию после "Вырезать"
                            }
                        }
                    }

                    //Обновляем статус основной категории
                    if ((\eMarket\Valid::inPOST('idsx_statusOn_key') == 'On')
                            or ( \eMarket\Valid::inPOST('idsx_statusOff_key') == 'Off')) {
                        \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET status=? WHERE id=?", [$status, $idx[$i]]);
                    }
                } else {
                    // Это товар
                    //Обновляем статус основного товара
                    if ((\eMarket\Valid::inPOST('idsx_statusOn_key') == 'On')
                            or ( \eMarket\Valid::inPOST('idsx_statusOff_key') == 'Off')) {
                        $id_prod = explode('product_', $idx[$i]);
                        \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET status=? WHERE id=?", [$status, $id_prod[1]]);
                    }
                }
            }
        }

        // Если parrent_id является массивом, то
        if (is_array($parent_id) == TRUE) {
            $parent_id = 0;
        }

        return $parent_id;
    }

    /**
     * Скидка в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $TABLE_PRODUCTS (название таблицы товаров)
     * @param string $parent_id (идентификатор родительской категории)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private static function sale($TABLE_CATEGORIES, $TABLE_PRODUCTS, $parent_id) {

        if ((\eMarket\Valid::inPOST('idsx_saleOn_key') == 'On')
                or ( \eMarket\Valid::inPOST('idsx_saleOff_key') == 'Off')
                or ( \eMarket\Valid::inPOST('idsx_saleOffAll_key') == 'OffAll')) {

            $parent_id_real = (int) \eMarket\Valid::inPOST('idsx_real_parent_id'); // получить значение из JS

            if (\eMarket\Valid::inPOST('idsx_saleOn_key') == 'On') {
                // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_saleOn_id'));
                $discount = \eMarket\Valid::inPOST('sale');
            }

            if (\eMarket\Valid::inPOST('idsx_saleOff_key') == 'Off') {
                // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_saleOff_id'));
                $discount = '';
                $discount_id = \eMarket\Valid::inPOST('sale');
            }

            if (\eMarket\Valid::inPOST('idsx_saleOffAll_key') == 'OffAll') {
                // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_saleOffAll_id'));
                $discount = '';
                $discount_id = \eMarket\Valid::inPOST('sale');
            }

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    // Это категория
                    $parent_id = self::dataParentId($TABLE_CATEGORIES, $idx[$i]);
                    $keys = self::dataKeys($TABLE_CATEGORIES, $idx[$i]);

                    $count_keys = count($keys); // Получаем количество значений в массиве
                    for ($x = 0; $x < $count_keys; $x++) {

                        //Обновляем статус подкатегорий
                        if (\eMarket\Valid::inPOST('idsx_saleOn_key') == 'On') {
                            // Это товар
                            $discount_id_array = \eMarket\Pdo::getCol("SELECT id FROM " . $TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($discount_id_array as $discount_id_arr) {
                                $discount_str_temp = \eMarket\Pdo::getCell("SELECT discount FROM " . $TABLE_PRODUCTS . " WHERE id=?", [$discount_id_arr]);
                                $discount_str_explode_temp = explode(',', $discount_str_temp);
                                $discount_str_explode = \eMarket\Func::deleteEmptyInArray($discount_str_explode_temp);
                                if (!in_array($discount, $discount_str_explode)) {
                                    array_push($discount_str_explode, $discount);
                                }
                                $discount_str_implode = implode(',', $discount_str_explode);
                                \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET discount=? WHERE id=?", [$discount_str_implode, $discount_id_arr]);
                            }

                            if ($parent_id_real > 0) {
                                $parent_id = $parent_id_real; // Возвращаемся в свою директорию после "Вырезать"
                            }
                        }
                        if (\eMarket\Valid::inPOST('idsx_saleOff_key') == 'Off') {
                            // Это товар
                            $discount_id_array = \eMarket\Pdo::getCol("SELECT id FROM " . $TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($discount_id_array as $discount_id_arr) {
                                $discount_str_temp = \eMarket\Pdo::getCell("SELECT discount FROM " . $TABLE_PRODUCTS . " WHERE id=?", [$discount_id_arr]);
                                $discount_str_explode_temp = explode(',', $discount_str_temp);
                                $discount_str_explode = \eMarket\Func::deleteValInArray(\eMarket\Func::deleteEmptyInArray($discount_str_explode_temp), [$discount_id]);
                                $discount_str_implode = implode(',', $discount_str_explode);
                                \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET discount=? WHERE id=?", [$discount_str_implode, $discount_id_arr]);
                            }
                            if ($parent_id_real > 0) {
                                $parent_id = $parent_id_real; // Возвращаемся в свою директорию после "Вырезать"
                            }
                        }
                        if (\eMarket\Valid::inPOST('idsx_saleOffAll_key') == 'OffAll') {
                            // Это товар
                            $discount_id_array = \eMarket\Pdo::getCol("SELECT id FROM " . $TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($discount_id_array as $discount_id_arr) {
                                \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET discount=? WHERE id=?", ['', $discount_id_arr]);
                            }
                            if ($parent_id_real > 0) {
                                $parent_id = $parent_id_real; // Возвращаемся в свою директорию после "Вырезать"
                            }
                        }
                    }
                } else {
                    // Это товар
                    //Обновляем статус основного товара
                    if (\eMarket\Valid::inPOST('idsx_saleOn_key') == 'On') {
                        $id_prod = explode('product_', $idx[$i]);
                        $discount_str_temp = \eMarket\Pdo::getCell("SELECT discount FROM " . $TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);
                        $discount_str_explode_temp = explode(',', $discount_str_temp);
                        $discount_str_explode = \eMarket\Func::deleteEmptyInArray($discount_str_explode_temp);
                        if (!in_array($discount, $discount_str_explode)) {
                            array_push($discount_str_explode, $discount);
                        }
                        $discount_str_implode = implode(',', $discount_str_explode);
                        \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET discount=? WHERE id=?", [$discount_str_implode, $id_prod[1]]);
                    }
                    if (\eMarket\Valid::inPOST('idsx_saleOff_key') == 'Off') {
                        $id_prod = explode('product_', $idx[$i]);
                        $discount_str_temp = \eMarket\Pdo::getCell("SELECT discount FROM " . $TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);
                        $discount_str_explode_temp = explode(',', $discount_str_temp);
                        $discount_str_explode = \eMarket\Func::deleteValInArray(\eMarket\Func::deleteEmptyInArray($discount_str_explode_temp), [$discount_id]);
                        $discount_str_implode = implode(',', $discount_str_explode);
                        \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET discount=? WHERE id=?", [$discount_str_implode, $id_prod[1]]);
                    }
                    if (\eMarket\Valid::inPOST('idsx_saleOffAll_key') == 'OffAll') {
                        $id_prod = explode('product_', $idx[$i]);
                        \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET discount=? WHERE id=?", ['', $id_prod[1]]);
                    }
                }
            }
        }

        // Если parrent_id является массивом, то
        if (is_array($parent_id) == TRUE) {
            $parent_id = 0;
        }

        return $parent_id;
    }

    /**
     * Стикер в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $TABLE_PRODUCTS (название таблицы товаров)
     * @param string $parent_id (идентификатор родительской категории)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private static function stiker($TABLE_CATEGORIES, $TABLE_PRODUCTS, $parent_id) {

        if ((\eMarket\Valid::inPOST('idsx_stikerOn_key') == 'On')
                or ( \eMarket\Valid::inPOST('idsx_stikerOff_key') == 'Off')) {

            $parent_id_real = (int) \eMarket\Valid::inPOST('idsx_real_parent_id'); // получить значение из JS

            if (\eMarket\Valid::inPOST('idsx_stikerOn_key') == 'On') {
                // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_stikerOn_id'));
                $stiker = \eMarket\Valid::inPOST('stiker');
            }

            if (\eMarket\Valid::inPOST('idsx_stikerOff_key') == 'Off') {
                // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_stikerOff_id'));
                $stiker = '';
                $stiker_id = \eMarket\Valid::inPOST('stiker');
            }

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    // Это категория
                    $parent_id = self::dataParentId($TABLE_CATEGORIES, $idx[$i]);
                    $keys = self::dataKeys($TABLE_CATEGORIES, $idx[$i]);

                    $count_keys = count($keys); // Получаем количество значений в массиве
                    for ($x = 0; $x < $count_keys; $x++) {

                        //Обновляем статус подкатегорий
                        if (\eMarket\Valid::inPOST('idsx_stikerOn_key') == 'On' OR \eMarket\Valid::inPOST('idsx_stikerOff_key') == 'Off') {
                            // Это товар
                            $stiker_id_array = \eMarket\Pdo::getCol("SELECT id FROM " . $TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($stiker_id_array as $stiker_id_arr) {
                                \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET stiker=? WHERE id=?", [$stiker, $stiker_id_arr]);
                            }

                            if ($parent_id_real > 0) {
                                $parent_id = $parent_id_real; // Возвращаемся в свою директорию после "Вырезать"
                            }
                        }
                    }
                } else {
                    // Это товар
                    //Обновляем статус основного товара
                    if (\eMarket\Valid::inPOST('idsx_stikerOn_key') == 'On' OR \eMarket\Valid::inPOST('idsx_stikerOff_key') == 'Off') {
                        $id_prod = explode('product_', $idx[$i]);
                        \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET stiker=? WHERE id=?", [$stiker, $id_prod[1]]);
                    }
                }
            }
        }

        // Если parrent_id является массивом, то
        if (is_array($parent_id) == TRUE) {
            $parent_id = 0;
        }

        return $parent_id;
    }

    /**
     * Установка parent_id при навигации в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $idx (идентификатор)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private static function dataParentId($TABLE_CATEGORIES, $idx) {

        // Устанавливаем родительскую категорию
        $parent_id = \eMarket\Pdo::selectPrepare("SELECT parent_id FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$idx]);
        // Устанавливаем родительскую категорию родительской категории
        $parent_id_up = \eMarket\Pdo::selectPrepare("SELECT parent_id FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$parent_id]);
        // считаем одинаковые parent_id
        $parent_id_num = \eMarket\Pdo::getColRow("SELECT id FROM " . $TABLE_CATEGORIES . " WHERE parent_id=?", [$parent_id]);
        // если меньше 2-х значений, то устанавливаем parent_id как родительский родительского
        if (count($parent_id_num) < 2) {
            $parent_id = $parent_id_up;
        }

        return $parent_id;
    }

    /**
     * Ключ категорий в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $idx (идентификатор)
     * @return array $keys
     */
    private static function dataKeys($TABLE_CATEGORIES, $idx) {

        //Выбираем данные из БД
        $data_cat = \eMarket\Pdo::inPrepare("SELECT id, parent_id FROM " . $TABLE_CATEGORIES);

        $category = $idx; // id родителя
        $categories = [];
        $keys[] = $category; // добавляем первый ключ в массив
        // В цикле формируем ассоциативный массив разделов
        while ($category = $data_cat->fetch(\PDO::FETCH_ASSOC)) {
            // Проверяем наличие id категории в массиве ключей
            if (in_array($category['parent_id'], $keys)) {
                $categories[$category['parent_id']][] = $category['id'];
                $keys[] = $category['id']; // расширяем массив
            }
        }

        return $keys;
    }

    /**
     * Добавить товар в EAC
     * @param array $TABLES (названия таблиц)
     * @param string $parent_id (идентификатор родительской категории)
     */
    private static function addProduct($TABLES, $parent_id) {

        $LANG_COUNT = count(lang('#lang_all'));

        $TABLE_PRODUCTS = $TABLES[1];
        $TABLE_TAXES = $TABLES[2];
        $TABLE_UNITS = $TABLES[3];
        $TABLE_MANUFACTURERS = $TABLES[4];
        $TABLE_VENDOR_CODES = $TABLES[5];
        $TABLE_WEIGHT = $TABLES[6];
        $TABLE_LENGTH = $TABLES[7];
        $TABLE_CURRENCIES = $TABLES[8];

        // Если нажали на кнопку Добавить товар
        if (\eMarket\Valid::inPOST('add_product')) {

            // Формат даты после Datepicker
            if (\eMarket\Valid::inPOST('date_available_product_stock')) {
                $date_available = date('Y-m-d', strtotime(\eMarket\Valid::inPOST('date_available_product_stock')));
            } else {

                $date_available = NULL;
            }

            if (\eMarket\Valid::inPOST('view_product_stock')) {
                $view_product = 1;
            } else {
                $view_product = 0;
            }

            if (\eMarket\Valid::inPOST('tax_product_stock')) {
                $tax_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_TAXES . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('tax_product_stock')]);
            } else {
                $tax_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('unit_product_stock')) {
                $unit_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_UNITS . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('unit_product_stock')]);
            } else {
                $unit_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('manufacturers_product_stock')) {
                $manufacturers_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_MANUFACTURERS . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('manufacturers_product_stock')]);
            } else {
                $manufacturers_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('vendor_codes_product_stock')) {
                $vendor_codes_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_VENDOR_CODES . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('vendor_codes_product_stock')]);
            } else {
                $vendor_codes_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('weight_product_stock')) {
                $weight_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_WEIGHT . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('weight_product_stock')]);
            } else {
                $weight_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('length_product_stock')) {
                $length_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_LENGTH . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('length_product_stock')]);
            } else {
                $length_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('currency_product_stock')) {
                $currency_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_CURRENCIES . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('currency_product_stock')]);
            } else {
                $currency_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('weight_value_product_stock')) {
                $weight_value_product_stock = \eMarket\Valid::inPOST('weight_value_product_stock');
            } else {
                $weight_value_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('value_length_product_stock')) {
                $value_length_product_stock = \eMarket\Valid::inPOST('value_length_product_stock');
            } else {
                $value_length_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('value_width_product_stock')) {
                $value_width_product_stock = \eMarket\Valid::inPOST('value_width_product_stock');
            } else {
                $value_width_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('value_height_product_stock')) {
                $value_height_product_stock = \eMarket\Valid::inPOST('value_height_product_stock');
            } else {
                $value_height_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('min_quantity_product_stock')) {
                $min_quantity_product_stock = \eMarket\Valid::inPOST('min_quantity_product_stock');
            } else {
                $min_quantity_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('selected_attributes')) {
                $selected_attributes_product_stock = \eMarket\Valid::inPOST('selected_attributes');
            } else {
                $selected_attributes_product_stock = json_encode([]);
            }

            // Получаем последний id и увеличиваем его на 1
            $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_PRODUCTS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            // добавляем запись для всех вкладок
            for ($x = 0; $x < $LANG_COUNT; $x++) {
                \eMarket\Pdo::inPrepare("INSERT INTO " . $TABLE_PRODUCTS .
                        " SET id=?, name=?, language=?, parent_id=?, date_added=?, date_available=?, model=?, price=?, currency=?, quantity=?, unit=?, keyword=?, tags=?, description=?, tax=?, manufacturer=?, vendor_code=?, vendor_code_value=?, weight=?, weight_value=?, dimension=?, length=?, width=?, height=?, min_quantity=?, logo=?, attributes=?", [
                    $id, \eMarket\Valid::inPOST('name_product_stock_' . $x), lang('#lang_all')[$x], $parent_id, date("Y-m-d H:i:s"), $date_available, \eMarket\Valid::inPOST('model_product_stock'), \eMarket\Valid::inPOST('price_product_stock'), $currency_product_stock, \eMarket\Valid::inPOST('quantity_product_stock'), $unit_product_stock, \eMarket\Valid::inPOST('keyword_product_stock_' . $x), \eMarket\Valid::inPOST('tags_product_stock_' . $x), \eMarket\Valid::inPOST('description_product_stock_' . $x),
                    $tax_product_stock, $manufacturers_product_stock, $vendor_codes_product_stock, \eMarket\Valid::inPOST('vendor_code_value_product_stock'), $weight_product_stock, $weight_value_product_stock, $length_product_stock, $value_length_product_stock, $value_width_product_stock, $value_height_product_stock, $min_quantity_product_stock, json_encode([]), $selected_attributes_product_stock
                ]);
            }
            // Выводим сообщение об успехе
            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Редактировать товар в EAC
     * @param array $TABLES (названия таблиц)
     */
    private static function editProduct($TABLES) {

        $LANG_COUNT = count(lang('#lang_all'));

        $TABLE_PRODUCTS = $TABLES[1];
        $TABLE_TAXES = $TABLES[2];
        $TABLE_UNITS = $TABLES[3];
        $TABLE_MANUFACTURERS = $TABLES[4];
        $TABLE_VENDOR_CODES = $TABLES[5];
        $TABLE_WEIGHT = $TABLES[6];
        $TABLE_LENGTH = $TABLES[7];
        $TABLE_CURRENCIES = $TABLES[8];

        // Если нажали на кнопку Редактировать товар
        if (\eMarket\Valid::inPOST('edit_product')) {

            // Формат даты после Datepicker
            if (\eMarket\Valid::inPOST('date_available_product_stock')) {
                $date_available = date('Y-m-d', strtotime(\eMarket\Valid::inPOST('date_available_product_stock')));
            } else {
                $date_available = NULL;
            }

            if (\eMarket\Valid::inPOST('view_product_stock')) {
                $view_product = 1;
            } else {
                $view_product = 0;
            }

            if (\eMarket\Valid::inPOST('tax_product_stock')) {
                $tax_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_TAXES . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('tax_product_stock')]);
            } else {
                $tax_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('unit_product_stock')) {
                $unit_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_UNITS . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('unit_product_stock')]);
            } else {
                $unit_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('manufacturers_product_stock')) {
                $manufacturers_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_MANUFACTURERS . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('manufacturers_product_stock')]);
            } else {
                $manufacturers_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('vendor_codes_product_stock')) {
                $vendor_codes_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_VENDOR_CODES . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('vendor_codes_product_stock')]);
            } else {
                $vendor_codes_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('weight_product_stock')) {
                $weight_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_WEIGHT . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('weight_product_stock')]);
            } else {
                $weight_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('length_product_stock')) {
                $length_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_LENGTH . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('length_product_stock')]);
            } else {
                $length_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('currency_product_stock')) {
                $currency_product_stock = (int) \eMarket\Pdo::selectPrepare("SELECT id FROM " . $TABLE_CURRENCIES . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('currency_product_stock')]);
            } else {
                $currency_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('weight_value_product_stock')) {
                $weight_value_product_stock = \eMarket\Valid::inPOST('weight_value_product_stock');
            } else {
                $weight_value_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('value_length_product_stock')) {
                $value_length_product_stock = \eMarket\Valid::inPOST('value_length_product_stock');
            } else {
                $value_length_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('value_width_product_stock')) {
                $value_width_product_stock = \eMarket\Valid::inPOST('value_width_product_stock');
            } else {
                $value_width_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('value_height_product_stock')) {
                $value_height_product_stock = \eMarket\Valid::inPOST('value_height_product_stock');
            } else {
                $value_height_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('min_quantity_product_stock')) {
                $min_quantity_product_stock = \eMarket\Valid::inPOST('min_quantity_product_stock');
            } else {
                $min_quantity_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('selected_attributes')) {
                $selected_attributes_product_stock = \eMarket\Valid::inPOST('selected_attributes');
            } else {
                $selected_attributes_product_stock = json_encode([]);
            }

            // добавляем запись для всех вкладок
            for ($x = 0; $x < $LANG_COUNT; $x++) {
                \eMarket\Pdo::inPrepare("UPDATE " . $TABLE_PRODUCTS .
                        " SET name=?, last_modified=?, date_available=?, model=?, price=?, currency=?, quantity=?, unit=?, keyword=?, tags=?, description=?, tax=?, manufacturer=?, vendor_code=?, vendor_code_value=?, weight=?, weight_value=?, dimension=?, length=?, width=?, height=?, min_quantity=?, attributes=? WHERE id=? AND language=?", [
                    \eMarket\Valid::inPOST('name_product_stock_' . $x), date("Y-m-d H:i:s"), $date_available, \eMarket\Valid::inPOST('model_product_stock'), \eMarket\Valid::inPOST('price_product_stock'), $currency_product_stock, \eMarket\Valid::inPOST('quantity_product_stock'), $unit_product_stock, \eMarket\Valid::inPOST('keyword_product_stock_' . $x), \eMarket\Valid::inPOST('tags_product_stock_' . $x), \eMarket\Valid::inPOST('description_product_stock_' . $x),
                    $tax_product_stock, $manufacturers_product_stock, $vendor_codes_product_stock, \eMarket\Valid::inPOST('vendor_code_value_product_stock'), $weight_product_stock, $weight_value_product_stock, $length_product_stock, $value_length_product_stock, $value_width_product_stock, $value_height_product_stock, $min_quantity_product_stock, $selected_attributes_product_stock, \eMarket\Valid::inPOST('edit_product'), lang('#lang_all')[$x]
                ]);
            }
            // Выводим сообщение об успехе
            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

}

?>