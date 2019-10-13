<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Движок EAC (Easy Ajax Catalog) v.1.0
 *
 * @package Eac
 * @author eMarket
 * 
 */
final class Eac {

    /**
     * Инициализация EAC
     * @param array $TABLES (названия таблиц)
     * @param string $TOKEN (токен)
     * @param array $resize_param (параметры ресайза)
     * @param array $resize_param_product (параметры ресайза фото товаров)
     * @return array array($idsx_real_parent_id, $parent_id)
     */
    public function start($TABLES, $TOKEN, $resize_param, $resize_param_product) {

        $FILES = new \eMarket\Other\Files;

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
        $FILES->imgUpload($TABLES[0], 'categories', $resize_param);

        // Загручик изображений товаров (ВСТАВЛЯТЬ ПЕРЕД УДАЛЕНИЕМ)
        $FILES->imgUploadProduct($TABLES[1], 'products', $resize_param_product);

        $idsx_real_parent_id = $parent_id; //для отправки в JS
        // Если нажали на кнопку Удалить
        $parent_id_delete = self::delete($TABLES[0], $TABLES[1], $parent_id);

        // Если нажали на кнопку Вырезать
        $parent_id_cut = self::cut($TABLES[0], $parent_id);

        // Если нажали на кнопку Вставить
        $parent_id_paste = self::paste($TABLES[0], $TABLES[1], $parent_id);

        // Если нажали на кнопку Скрыть/Отобразить
        $parent_id_status = self::status($TABLES[0], $TABLES[1], $parent_id);

        // Сортировка мышкой EAC
        self::sortList($TABLES[0], $TOKEN);

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

        return array($idsx_real_parent_id, $parent_id);
    }

    /**
     * Первоначальная установка parent_id родительской категории
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private function parentIdStart($TABLE_CATEGORIES) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        // Устанавливаем родительскую категорию
        $parent_id = $VALID->inPOST('parent_id');
        if ($parent_id == FALSE) {
            $parent_id = 0;
        }

        // Устанавливаем родительскую категорию при переходе на уровень выше
        if ($VALID->inGET('parent_up')) {
            $parent_id = $PDO->selectPrepare("SELECT parent_id FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$VALID->inGET('parent_up')]);
        }

        // Устанавливаем родительскую категорию при переходе на уровень ниже
        if ($VALID->inGET('parent_down')) {
            $parent_id = $VALID->inGET('parent_down');
        }

        return $parent_id;
    }

    /**
     * Сортировка мышкой в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $TOKEN (токен)
     */
    private function sortList($TABLE_CATEGORIES, $TOKEN) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
        $FUNC = new \eMarket\Other\Func;

        // если сортируем категории мышкой
        if ($VALID->inPOST('token_ajax') == $TOKEN && $VALID->inPOST('ids')) {
            $sort_array_id_ajax = explode(',', $VALID->inPOST('ids')); // Массив со списком id под сортировку
            // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
            $sort_array_id = $FUNC->deleteEmptyInArray($sort_array_id_ajax);

            $sort_array_category = []; // Массив со списком sort_category под сортировку

            $count_sort_array_id = count($sort_array_id); // Получаем количество значений в массиве

            for ($i = 0; $i < $count_sort_array_id; $i++) {
                $sort_category = $PDO->selectPrepare("SELECT sort_category FROM " . $TABLE_CATEGORIES . " WHERE id=? AND language=? ORDER BY id ASC", [$sort_array_id[$i], lang('#lang_all')[0]]);
                array_push($sort_array_category, $sort_category); // Добавляем данные в массив sort_category
                arsort($sort_array_category); // Сортируем массив со списком sort_category
            }
            // Создаем финальный массив из двух массивов
            $sort_array_final = array_combine($sort_array_id, $sort_array_category);

            for ($i = 0; $i < $count_sort_array_id; $i++) {

                $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET sort_category=? WHERE id=?", [(int) $sort_array_final[$sort_array_id[$i]], (int) $sort_array_id[$i]]);
            }
        }
    }

    /**
     * Добавить категорию в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $parent_id (идентификатор родительской категории)
     */
    private function addCategory($TABLE_CATEGORIES, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
        $LANG_COUNT = count(lang('#lang_all'));

        if ($VALID->inPOST('add')) {

            if ($VALID->inPOST('view_categories_stock')) {
                $view_cat = 1;
            } else {
                $view_cat = 0;
            }

            // Получаем последний sort_category в текущем parent_id и увеличиваем его на 1
            $sort_max = $PDO->selectPrepare("SELECT sort_category FROM " . $TABLE_CATEGORIES . " WHERE language=? AND parent_id=? ORDER BY sort_category DESC", [lang('#lang_all')[0], $parent_id]);
            $sort_category = intval($sort_max) + 1;

            // Получаем последний id и увеличиваем его на 1
            $id_max = $PDO->selectPrepare("SELECT id FROM " . $TABLE_CATEGORIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            // добавляем запись для всех вкладок
            for ($x = 0; $x < $LANG_COUNT; $x++) {
                $PDO->inPrepare("INSERT INTO " . $TABLE_CATEGORIES . " SET id=?, name=?, sort_category=?, language=?, parent_id=?, date_added=?, status=?", [$id, $VALID->inPOST('name_categories_stock_' . $x), $sort_category, lang('#lang_all')[$x], $parent_id, date("Y-m-d H:i:s"), $view_cat]);
            }
            // Выводим сообщение об успехе
            $_SESSION['message'] = ['success', lang('action_completed_successfully')];
        }
    }

    /**
     * Редактировать категорию в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     */
    private function editCategory($TABLE_CATEGORIES) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
        $LANG_COUNT = count(lang('#lang_all'));

        if ($VALID->inPOST('edit')) {

            for ($x = 0; $x < $LANG_COUNT; $x++) {
                // обновляем запись
                $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET name=?, last_modified=? WHERE id=? AND language=?", [$VALID->inPOST('name_categories_stock_edit_' . $x), date("Y-m-d H:i:s"), $VALID->inPOST('edit'), lang('#lang_all')[$x]]);
            }
            // Выводим сообщение об успехе
            $_SESSION['message'] = ['success', lang('action_completed_successfully')];
        }
    }

    /**
     * Удаляем категорию в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $TABLE_PRODUCTS (название таблицы товаров)
     * @param string $parent_id (идентификатор родительской категории)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private function delete($TABLE_CATEGORIES, $TABLE_PRODUCTS, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
        $FUNC = new \eMarket\Other\Func;

        if ($VALID->inPOST('delete')) {

            // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
            $idx = $FUNC->deleteEmptyInArray($VALID->inPOST('delete'));

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    // Это категория
                    $parent_id = self::dataParentId($TABLE_CATEGORIES, $idx[$i]);
                    $keys = self::dataKeys($TABLE_CATEGORIES, $idx[$i]);

                    $count_keys = count($keys); // Получаем количество значений в массиве
                    for ($x = 0; $x < $count_keys; $x++) {

                        //Удаляем товар  
                        $PDO->inPrepare("DELETE FROM " . $TABLE_PRODUCTS . " WHERE parent_id=?", [$keys[$x]]);

                        //Удаляем подкатегории
                        $PDO->inPrepare("DELETE FROM " . $TABLE_CATEGORIES . " WHERE parent_id=?", [$keys[$x]]);
                    }

                    //Удаляем основную категорию    
                    $PDO->inPrepare("DELETE FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$idx[$i]]);

                    //Удаляем из буффера, если есть
                    if (isset($_SESSION['buffer']['cat']) && $_SESSION['buffer']['cat'] != FALSE) {
                        $_SESSION['buffer']['cat'] = $FUNC->deleteValInArray($_SESSION['buffer']['cat'], [$idx[$i]]);
                        if (count($_SESSION['buffer']['cat']) == 0) {
                            unset($_SESSION['buffer']['cat']);
                        }
                    }
                } else {
                    // Это товар
                    $id_prod = explode('product_', $idx[$i]);
                    //Удаляем основной товар
                    $PDO->inPrepare("DELETE FROM " . $TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);

                    //Удаляем из буффера, если есть
                    if (isset($_SESSION['buffer']['prod']) && $_SESSION['buffer']['prod'] != FALSE) {
                        $_SESSION['buffer']['prod'] = $FUNC->deleteValInArray($_SESSION['buffer']['prod'], [$id_prod[1]]);
                        if (count($_SESSION['buffer']['prod']) == 0) {
                            unset($_SESSION['buffer']['prod']);
                        }
                    }
                }
                // Выводим сообщение об успехе
                $_SESSION['message'] = ['success', lang('action_completed_successfully')];
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
    private function cut($TABLE_CATEGORIES, $parent_id) {

        $VALID = new \eMarket\Core\Valid;
        $FUNC = new \eMarket\Other\Func;

        if ($VALID->inPOST('idsx_cut_marker') == 'cut') { // очищаем буфер обмена, если он был заполнен, при нажатии Вырезать
            unset($_SESSION['buffer']);
        }

        if (($VALID->inPOST('idsx_cut_key') == 'cut')) {
            // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
            $idx = $FUNC->deleteEmptyInArray($VALID->inPOST('idsx_cut_id'));
            for ($i = 0; $i < count($idx); $i++) {

                $parent_id_real = (int) $VALID->inPOST('idsx_real_parent_id'); // получить значение из JS
                $parent_id = self::dataParentId($TABLE_CATEGORIES, $idx[$i]);

                //Вырезаем основную родительскую категорию    
                if ($VALID->inPOST('idsx_cut_key') == 'cut') {
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
    private function paste($TABLE_CATEGORIES, $TABLE_PRODUCTS, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        //Вставляем вырезанные категории    
        if ($VALID->inPOST('idsx_paste_key') == 'paste' && isset($_SESSION['buffer']) == TRUE) {

            $parent_id_real = (int) $VALID->inPOST('idsx_real_parent_id'); // получить значение из JS
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
                    $sort_max = $PDO->selectPrepare("SELECT sort_category FROM " . $TABLE_CATEGORIES . " WHERE language=? AND parent_id=? ORDER BY sort_category DESC", [lang('#lang_all')[0], $parent_id_real]);
                    $sort_category = intval($sort_max) + 1;
                    // Обновляем данные
                    $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET parent_id=?, sort_category=? WHERE id=?", [$parent_id_real, $sort_category, $_SESSION['buffer']['cat'][$buf]]);
                }

                if (isset($_SESSION['buffer']['prod'][$buf]) && count($_SESSION['buffer']['prod']) > 0) {
                    // Это товар
                    // Обновляем данные
                    $PDO->inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET parent_id=? WHERE id=?", [$parent_id_real, $_SESSION['buffer']['prod'][$buf]]);
                }
            }
            unset($_SESSION['buffer']); // очищаем буфер обмена
            if ($parent_id_real > 0) {
                $parent_id = $parent_id_real; // Возвращаемся в свою директорию после вставки
            }
            // Выводим сообщение об успехе
            $_SESSION['message'] = ['success', lang('action_completed_successfully')];
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
    private function status($TABLE_CATEGORIES, $TABLE_PRODUCTS, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
        $FUNC = new \eMarket\Other\Func;

        if (($VALID->inPOST('idsx_statusOn_key') == 'statusOn')
                or ( $VALID->inPOST('idsx_statusOff_key') == 'statusOff')) {

            $parent_id_real = (int) $VALID->inPOST('idsx_real_parent_id'); // получить значение из JS

            if ($VALID->inPOST('idsx_statusOn_key') == 'statusOn') {
                // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
                $idx = $FUNC->deleteEmptyInArray($VALID->inPOST('idsx_statusOn_id'));
                $status = 1;
            }

            if ($VALID->inPOST('idsx_statusOff_key') == 'statusOff') {
                // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
                $idx = $FUNC->deleteEmptyInArray($VALID->inPOST('idsx_statusOff_id'));
                $status = 0;
            }
            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    // Это категория
                    $parent_id = self::dataParentId($TABLE_CATEGORIES, $idx[$i]);
                    $keys = self::dataKeys($TABLE_CATEGORIES, $idx[$i]);

                    $count_keys = count($keys); // Получаем количество значений в массиве
                    for ($x = 0; $x < $count_keys; $x++) {

                        //Обновляем статус подкатегорий
                        if (($VALID->inPOST('idsx_statusOn_key') == 'statusOn')
                                or ( $VALID->inPOST('idsx_statusOff_key') == 'statusOff')) {

                            // Это категория
                            $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET status=? WHERE parent_id=?", [$status, $keys[$x]]);

                            // Это товар
                            $PDO->inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET status=? WHERE parent_id=?", [$status, $keys[$x]]);

                            if ($parent_id_real > 0) {
                                $parent_id = $parent_id_real; // Возвращаемся в свою директорию после "Вырезать"
                            }
                        }
                    }

                    //Обновляем статус основной категории
                    if (($VALID->inPOST('idsx_statusOn_key') == 'statusOn')
                            or ( $VALID->inPOST('idsx_statusOff_key') == 'statusOff')) {
                        $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET status=? WHERE id=?", [$status, $idx[$i]]);
                    }
                } else {
                    // Это товар
                    //Обновляем статус основного товара
                    if (($VALID->inPOST('idsx_statusOn_key') == 'statusOn')
                            or ( $VALID->inPOST('idsx_statusOff_key') == 'statusOff')) {
                        $id_prod = explode('product_', $idx[$i]);
                        $PDO->inPrepare("UPDATE " . $TABLE_PRODUCTS . " SET status=? WHERE id=?", [$status, $id_prod[1]]);
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
    private function dataParentId($TABLE_CATEGORIES, $idx) {

        $PDO = new \eMarket\Core\Pdo;

        // Устанавливаем родительскую категорию
        $parent_id = $PDO->selectPrepare("SELECT parent_id FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$idx]);
        // Устанавливаем родительскую категорию родительской категории
        $parent_id_up = $PDO->selectPrepare("SELECT parent_id FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$parent_id]);
        // считаем одинаковые parent_id
        $parent_id_num = $PDO->getColRow("SELECT id FROM " . $TABLE_CATEGORIES . " WHERE parent_id=?", [$parent_id]);
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
    private function dataKeys($TABLE_CATEGORIES, $idx) {

        $PDO = new \eMarket\Core\Pdo;

        //Выбираем данные из БД
        $data_cat = $PDO->inPrepare("SELECT id, parent_id FROM " . $TABLE_CATEGORIES);

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
    private function addProduct($TABLES, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
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
        if ($VALID->inPOST('add_product')) {

            // Формат даты после Datepicker
            if ($VALID->inPOST('date_available_product_stock')) {
                $date_available = date('Y-m-d', strtotime($VALID->inPOST('date_available_product_stock')));
            } else {

                $date_available = NULL;
            }

            if ($VALID->inPOST('view_product_stock')) {
                $view_product = 1;
            } else {
                $view_product = 0;
            }

            if ($VALID->inPOST('tax_product_stock')) {
                $tax_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_TAXES . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('tax_product_stock')]);
            } else {
                $tax_product_stock = NULL;
            }

            if ($VALID->inPOST('unit_product_stock')) {
                $unit_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_UNITS . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('unit_product_stock')]);
            } else {
                $unit_product_stock = NULL;
            }

            if ($VALID->inPOST('manufacturers_product_stock')) {
                $manufacturers_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_MANUFACTURERS . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('manufacturers_product_stock')]);
            } else {
                $manufacturers_product_stock = NULL;
            }

            if ($VALID->inPOST('vendor_codes_product_stock')) {
                $vendor_codes_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_VENDOR_CODES . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('vendor_codes_product_stock')]);
            } else {
                $vendor_codes_product_stock = NULL;
            }

            if ($VALID->inPOST('weight_product_stock')) {
                $weight_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_WEIGHT . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('weight_product_stock')]);
            } else {
                $weight_product_stock = NULL;
            }

            if ($VALID->inPOST('length_product_stock')) {
                $length_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_LENGTH . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('length_product_stock')]);
            } else {
                $length_product_stock = NULL;
            }

            if ($VALID->inPOST('currency_product_stock')) {
                $currency_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_CURRENCIES . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('currency_product_stock')]);
            } else {
                $currency_product_stock = NULL;
            }

            if ($VALID->inPOST('weight_value_product_stock')) {
                $weight_value_product_stock = $VALID->inPOST('weight_value_product_stock');
            } else {
                $weight_value_product_stock = NULL;
            }

            if ($VALID->inPOST('value_length_product_stock')) {
                $value_length_product_stock = $VALID->inPOST('value_length_product_stock');
            } else {
                $value_length_product_stock = NULL;
            }

            if ($VALID->inPOST('value_width_product_stock')) {
                $value_width_product_stock = $VALID->inPOST('value_width_product_stock');
            } else {
                $value_width_product_stock = NULL;
            }
            
            if ($VALID->inPOST('value_height_product_stock')) {
                $value_height_product_stock = $VALID->inPOST('value_height_product_stock');
            } else {
                $value_height_product_stock = NULL;
            }
            
            if ($VALID->inPOST('min_quantity_product_stock')) {
                $min_quantity_product_stock = $VALID->inPOST('min_quantity_product_stock');
            } else {
                $min_quantity_product_stock = NULL;
            }

            // Получаем последний id и увеличиваем его на 1
            $id_max = $PDO->selectPrepare("SELECT id FROM " . $TABLE_PRODUCTS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            // добавляем запись для всех вкладок
            for ($x = 0; $x < $LANG_COUNT; $x++) {
                $PDO->inPrepare("INSERT INTO " . $TABLE_PRODUCTS .
                        " SET id=?, name=?, language=?, parent_id=?, date_added=?, date_available=?, model=?, price=?, currency=?, quantity=?, unit=?, keyword=?, tags=?, description=?, tax=?, manufacturer=?, vendor_code=?, vendor_code_value=?, weight=?, weight_value=?, dimension=?, lenght=?, width=?, height=?, min_quantity=?", [
                    $id, $VALID->inPOST('name_product_stock_' . $x), lang('#lang_all')[$x], $parent_id, date("Y-m-d H:i:s"), $date_available, $VALID->inPOST('model_product_stock'), $VALID->inPOST('price_product_stock'), $currency_product_stock, $VALID->inPOST('quantity_product_stock'), $unit_product_stock, $VALID->inPOST('keyword_product_stock_' . $x), $VALID->inPOST('tags_product_stock_' . $x), $VALID->inPOST('description_product_stock_' . $x),
                    $tax_product_stock, $manufacturers_product_stock, $vendor_codes_product_stock, $VALID->inPOST('vendor_code_value_product_stock'), $weight_product_stock, $weight_value_product_stock, $length_product_stock, $value_length_product_stock, $value_width_product_stock, $value_height_product_stock, $min_quantity_product_stock
                ]);
            }
            // Выводим сообщение об успехе
            $_SESSION['message'] = ['success', lang('action_completed_successfully')];
        }
    }

    /**
     * Редактировать товар в EAC
     * @param array $TABLES (названия таблиц)
     * @param string $parent_id (идентификатор родительской категории)
     */
    private function editProduct($TABLES, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
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
        if ($VALID->inPOST('edit_product')) {

            // Формат даты после Datepicker
            if ($VALID->inPOST('date_available_product_stock_edit')) {
                $date_available = date('Y-m-d', strtotime($VALID->inPOST('date_available_product_stock_edit')));
            } else {

                $date_available = NULL;
            }

            if ($VALID->inPOST('view_product_stock_edit')) {
                $view_product = 1;
            } else {
                $view_product = 0;
            }

            if ($VALID->inPOST('tax_product_stock_edit')) {
                $tax_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_TAXES . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('tax_product_stock_edit')]);
            } else {
                $tax_product_stock = NULL;
            }

            if ($VALID->inPOST('unit_product_stock_edit')) {
                $unit_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_UNITS . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('unit_product_stock_edit')]);
            } else {
                $unit_product_stock = NULL;
            }

            if ($VALID->inPOST('manufacturers_product_stock_edit')) {
                $manufacturers_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_MANUFACTURERS . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('manufacturers_product_stock_edit')]);
            } else {
                $manufacturers_product_stock = NULL;
            }

            if ($VALID->inPOST('vendor_codes_product_stock_edit')) {
                $vendor_codes_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_VENDOR_CODES . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('vendor_codes_product_stock_edit')]);
            } else {
                $vendor_codes_product_stock = NULL;
            }

            if ($VALID->inPOST('weight_product_stock_edit')) {
                $weight_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_WEIGHT . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('weight_product_stock_edit')]);
            } else {
                $weight_product_stock = NULL;
            }

            if ($VALID->inPOST('length_product_stock_edit')) {
                $length_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_LENGTH . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('length_product_stock_edit')]);
            } else {
                $length_product_stock = NULL;
            }

            if ($VALID->inPOST('currency_product_stock_edit')) {
                $currency_product_stock = (int) $PDO->selectPrepare("SELECT id FROM " . $TABLE_CURRENCIES . " WHERE language=? AND name=? ORDER BY id DESC", [lang('#lang_all')[0], $VALID->inPOST('currency_product_stock_edit')]);
            } else {
                $currency_product_stock = NULL;
            }
            
            if ($VALID->inPOST('weight_value_product_stock_edit')) {
                $weight_value_product_stock = $VALID->inPOST('weight_value_product_stock_edit');
            } else {
                $weight_value_product_stock = NULL;
            }

            if ($VALID->inPOST('value_length_product_stock_edit')) {
                $value_length_product_stock = $VALID->inPOST('value_length_product_stock_edit');
            } else {
                $value_length_product_stock = NULL;
            }

            if ($VALID->inPOST('value_width_product_stock_edit')) {
                $value_width_product_stock = $VALID->inPOST('value_width_product_stock_edit');
            } else {
                $value_width_product_stock = NULL;
            }
            
            if ($VALID->inPOST('value_height_product_stock_edit')) {
                $value_height_product_stock = $VALID->inPOST('value_height_product_stock_edit');
            } else {
                $value_height_product_stock = NULL;
            }        
            
            if ($VALID->inPOST('min_quantity_product_stock_edit')) {
                $min_quantity_product_stock = $VALID->inPOST('min_quantity_product_stock_edit');
            } else {
                $min_quantity_product_stock = NULL;
            }            

            // добавляем запись для всех вкладок
            for ($x = 0; $x < $LANG_COUNT; $x++) {
                $PDO->inPrepare("UPDATE " . $TABLE_PRODUCTS .
                        " SET name=?, parent_id=?, last_modified=?, date_available=?, model=?, price=?, currency=?, quantity=?, unit=?, keyword=?, tags=?, description=?, tax=?, manufacturer=?, vendor_code=?, vendor_code_value=?, weight=?, weight_value=?, dimension=?, lenght=?, width=?, height=?, min_quantity=? WHERE id=? AND language=?", [
                    $VALID->inPOST('name_product_stock_edit_' . $x), $parent_id, date("Y-m-d H:i:s"), $date_available, $VALID->inPOST('model_product_stock_edit'), $VALID->inPOST('price_product_stock_edit'), $currency_product_stock, $VALID->inPOST('quantity_product_stock_edit'), $unit_product_stock, $VALID->inPOST('keyword_product_stock_edit_' . $x), $VALID->inPOST('tags_product_stock_edit_' . $x), $VALID->inPOST('description_product_stock_edit_' . $x),
                    $tax_product_stock, $manufacturers_product_stock, $vendor_codes_product_stock, $VALID->inPOST('vendor_code_value_product_stock_edit'), $weight_product_stock, $weight_value_product_stock, $length_product_stock, $value_length_product_stock, $value_width_product_stock, $value_height_product_stock, $min_quantity_product_stock, $VALID->inPOST('edit_product'), lang('#lang_all')[$x]
                ]);
            }
            // Выводим сообщение об успехе
            $_SESSION['message'] = ['success', lang('action_completed_successfully')];
        }
    }

}

?>