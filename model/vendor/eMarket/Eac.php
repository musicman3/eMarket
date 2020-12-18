<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Easy Ajax Catalog
 *
 * @package Eac
 * @author eMarket
 * 
 */
final class Eac {

    public static $parent_id = 0;
    private static $resize_param = FALSE;
    private static $resize_param_product = FALSE;

    /**
     * Инициализация EAC / Init EAC
     * @param array $resize_param (параметры ресайза категорий / resize param for categories)
     * @param array $resize_param_product (параметры ресайза товаров/ resize param for products)
     * @return array [$idsx_real_parent_id, self::$parent_id]
     */
    public static function init($resize_param, $resize_param_product) {

        self::$resize_param = $resize_param;
        self::$resize_param_product = $resize_param_product;

        // parent_id
        self::parentIdStart();

        // Добавить / Add
        self::addCategory();

        // Редактировать / Edit
        self::editCategory();

        // Добавить товар / Add product
        self::addProduct();

        // Редактировать товар / Edit product
        self::editProduct();

        // Загручик изображений для категорий (ВСТАВЛЯТЬ ПЕРЕД УДАЛЕНИЕМ) / Image loader for categories (INSERT BEFORE DELETING)
        \eMarket\Files::imgUpload(TABLE_CATEGORIES, 'categories', self::$resize_param);

        // Загручик изображений для товаров (ВСТАВЛЯТЬ ПЕРЕД УДАЛЕНИЕМ) / Image loader for products (INSERT BEFORE DELETING)
        \eMarket\Files::imgUploadProduct(TABLE_PRODUCTS, 'products', self::$resize_param_product);

        $idsx_real_parent_id = self::$parent_id; //для отправки в JS / for sent to JS
        // Удалить / Delete
        self::delete();

        // Вырезать / Cut
        self::cut();

        // Вставить / Paste
        self::paste();

        // Скрыть и Отобразить / Hide and Show
        self::status();

        self::initDiscount();
        ;
        // Стикер / Stiker
        self::stiker();

        // Сортировка / Sorting
        self::sortList();

        return [$idsx_real_parent_id, self::$parent_id];
    }

    /**
     * Инициализация скидок / discount init
     */
    private static function initDiscount() {

        $active_modules = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=?", ['discount', '1']);

        foreach ($active_modules as $module) {
            $namespace = '\eMarket\Modules\Discount\\' . ucfirst($module['name']);
            $namespace::initEac();
        }
    }

    /**
     * Инициализация parent_id / parent_id init
     */
    private static function parentIdStart() {

        self::$parent_id = \eMarket\Valid::inPOST('parent_id');
        if (self::$parent_id == FALSE) {
            self::$parent_id = 0;
        }

        if (\eMarket\Valid::inGET('parent_up')) {
            self::$parent_id = \eMarket\Pdo::selectPrepare("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", [\eMarket\Valid::inGET('parent_up')]);
        }

        if (\eMarket\Valid::inGET('parent_down')) {
            self::$parent_id = \eMarket\Valid::inGET('parent_down');
        }

        if (\eMarket\Valid::inGET('nav_parent_id')) {
            self::$parent_id = \eMarket\Valid::inGET('nav_parent_id');
        }
    }

    /**
     * Сортировка / Sorting
     * @param string TABLE_CATEGORIES (название таблицы категорий / categories table name)
     */
    private static function sortList() {

        if (\eMarket\Valid::inPOST('ids')) {
            $sort_array_id_ajax = explode(',', \eMarket\Valid::inPOST('ids'));

            $sort_array_id = \eMarket\Func::deleteEmptyInArray($sort_array_id_ajax);

            $sort_array_category = [];

            foreach ($sort_array_id as $val) {
                $sort_category = \eMarket\Pdo::selectPrepare("SELECT sort_category FROM " . TABLE_CATEGORIES . " WHERE id=? AND language=? ORDER BY id ASC", [$val, lang('#lang_all')[0]]);
                array_push($sort_array_category, $sort_category);
                arsort($sort_array_category); //
            }

            $sort_array_final = array_combine($sort_array_id, $sort_array_category);

            foreach ($sort_array_id as $val) {
                \eMarket\Pdo::action("UPDATE " . TABLE_CATEGORIES . " SET sort_category=? WHERE id=?", [(int) $sort_array_final[$val], (int) $val]);
            }
        }
    }

    /**
     * Добавить категорию / Add category
     */
    private static function addCategory() {

        if (\eMarket\Valid::inPOST('add')) {

            $sort_max = \eMarket\Pdo::selectPrepare("SELECT sort_category FROM " . TABLE_CATEGORIES . " WHERE language=? AND parent_id=? ORDER BY sort_category DESC", [lang('#lang_all')[0], self::$parent_id]);
            $sort_category = intval($sort_max) + 1;

            $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_CATEGORIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if (\eMarket\Valid::inPOST('attributes')) {
                $attributes = \eMarket\Valid::inPOST('attributes');
            } else {
                $attributes = json_encode([]);
            }

            for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                \eMarket\Pdo::action("INSERT INTO " . TABLE_CATEGORIES . " SET id=?, name=?, sort_category=?, language=?, parent_id=?, date_added=?, status=?, logo=?, attributes=?", [$id, \eMarket\Valid::inPOST('name_categories_stock_' . $x), $sort_category, lang('#lang_all')[$x], self::$parent_id, date("Y-m-d H:i:s"), 1, json_encode([]), $attributes]);
            }

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Редактировать категорию / Edit category
     */
    private static function editCategory() {

        if (\eMarket\Valid::inPOST('edit')) {

            for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                \eMarket\Pdo::action("UPDATE " . TABLE_CATEGORIES . " SET name=?, last_modified=?, attributes=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_categories_stock_' . $x), date("Y-m-d H:i:s"), \eMarket\Valid::inPOST('attributes'), \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
            }

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Удалить категорию / Delete category
     */
    private static function delete() {

        if (\eMarket\Valid::inPOST('delete')) {

            $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('delete'));

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    // Это категория / This is category
                    self::$parent_id = self::dataParentId($idx[$i]);
                    $keys = self::dataKeys($idx[$i]);

                    $count_keys = count($keys);
                    for ($x = 0; $x < $count_keys; $x++) {

                        //Удаляем товар и изображения / Removing product and images
                        self::deleteImages(TABLE_PRODUCTS, $keys[$x], 'products');
                        \eMarket\Pdo::action("DELETE FROM " . TABLE_PRODUCTS . " WHERE parent_id=?", [$keys[$x]]);

                        //Удаляем подкатегории и изображения / Removing subcategories and images
                        self::deleteImages(TABLE_CATEGORIES, $keys[$x], 'categories');
                        \eMarket\Pdo::action("DELETE FROM " . TABLE_CATEGORIES . " WHERE parent_id=?", [$keys[$x]]);
                    }

                    //Удаляем основную категорию / Removing general category
                    \eMarket\Pdo::action("DELETE FROM " . TABLE_CATEGORIES . " WHERE id=?", [$idx[$i]]);

                    // Очищаем буфер / Buffer empty
                    if (isset($_SESSION['buffer']['cat']) && $_SESSION['buffer']['cat'] != FALSE) {
                        $_SESSION['buffer']['cat'] = \eMarket\Func::deleteValInArray($_SESSION['buffer']['cat'], [$idx[$i]]);
                        if (count($_SESSION['buffer']['cat']) == 0) {
                            unset($_SESSION['buffer']['cat']);
                        }
                    }
                } else {
                    // Это товар / This is product
                    $id_prod = explode('product_', $idx[$i]);
                    //Удаляем основной товар / Removing general product
                    \eMarket\Pdo::action("DELETE FROM " . TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);

                    // Очищаем буфер / Buffer empty
                    if (isset($_SESSION['buffer']['prod']) && $_SESSION['buffer']['prod'] != FALSE) {
                        $_SESSION['buffer']['prod'] = \eMarket\Func::deleteValInArray($_SESSION['buffer']['prod'], [$id_prod[1]]);
                        if (count($_SESSION['buffer']['prod']) == 0) {
                            unset($_SESSION['buffer']['prod']);
                        }
                    }
                }

                \eMarket\Messages::alert('success', lang('action_completed_successfully'));
            }
        }

        if (is_array(self::$parent_id) == TRUE) {
            self::$parent_id = 0;
        }
    }

    /**
     * Вырезаем категорию / Cut category
     */
    private static function cut() {

        if (\eMarket\Valid::inPOST('idsx_cut_marker') == 'cut') {
            unset($_SESSION['buffer']);
        }

        if ((\eMarket\Valid::inPOST('idsx_cut_key') == 'cut')) {
            $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_cut_id'));

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {

                $parent_id_real = (int) \eMarket\Valid::inPOST('idsx_real_parent_id'); // получить значение из JS
                self::$parent_id = self::dataParentId($idx[$i]);

                if (\eMarket\Valid::inPOST('idsx_cut_key') == 'cut') {
                    // Это категория / This is category
                    if (strstr($idx[$i], '_', true) != 'product') {
                        if (!isset($_SESSION['buffer']['cat'])) {
                            $_SESSION['buffer']['cat'] = [];
                        }
                        array_push($_SESSION['buffer']['cat'], $idx[$i]);
                        if ($parent_id_real > 0) {
                            self::$parent_id = $parent_id_real;
                        }
                    } else {
                        // Это товар / This is product
                        if (!isset($_SESSION['buffer']['prod'])) {
                            $_SESSION['buffer']['prod'] = [];
                        }
                        $id_prod = explode('product_', $idx[$i]);
                        array_push($_SESSION['buffer']['prod'], $id_prod[1]);
                        if ($parent_id_real > 0) {
                            self::$parent_id = $parent_id_real;
                        }
                    }
                }
            }
        }

        if (is_array(self::$parent_id) == TRUE) {
            self::$parent_id = 0;
        }
    }

    /**
     * Вставляем категорию / Paste category
     */
    private static function paste() {

        if (\eMarket\Valid::inPOST('idsx_paste_key') == 'paste' && isset($_SESSION['buffer']) == TRUE) {

            $parent_id_real = (int) \eMarket\Valid::inPOST('idsx_real_parent_id');
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

            $count_session_buffer = $count_session_buffer_cat + $count_session_buffer_prod;

            for ($buf = 0; $buf < $count_session_buffer; $buf++) {
                // Это категория / This is category
                if (isset($_SESSION['buffer']['cat'][$buf]) && count($_SESSION['buffer']['cat']) > 0) {
                    $sort_max = \eMarket\Pdo::selectPrepare("SELECT sort_category FROM " . TABLE_CATEGORIES . " WHERE language=? AND parent_id=? ORDER BY sort_category DESC", [lang('#lang_all')[0], $parent_id_real]);
                    $sort_category = intval($sort_max) + 1;
                    \eMarket\Pdo::action("UPDATE " . TABLE_CATEGORIES . " SET parent_id=?, sort_category=? WHERE id=?", [$parent_id_real, $sort_category, $_SESSION['buffer']['cat'][$buf]]);
                }

                if (isset($_SESSION['buffer']['prod'][$buf]) && count($_SESSION['buffer']['prod']) > 0) {
                    // Это товар / This is product
                    \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET parent_id=?, attributes=? WHERE id=?", [$parent_id_real, json_encode([]), $_SESSION['buffer']['prod'][$buf]]);
                }
            }
            unset($_SESSION['buffer']); // очищаем буфер / Buffer empty
            if ($parent_id_real > 0) {
                self::$parent_id = $parent_id_real; //
            }

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }

        if (is_array(self::$parent_id) == TRUE) {
            self::$parent_id = 0;
        }
    }

    /**
     * Статус категорий / Categories status
     */
    private static function status() {

        if ((\eMarket\Valid::inPOST('idsx_status_on_key') == 'On')
                or ( \eMarket\Valid::inPOST('idsx_status_off_key') == 'Off')) {

            $parent_id_real = (int) \eMarket\Valid::inPOST('idsx_real_parent_id');

            if (\eMarket\Valid::inPOST('idsx_status_on_key') == 'On') {
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_status_on_id'));
                $status = 1;
            }

            if (\eMarket\Valid::inPOST('idsx_status_off_key') == 'Off') {
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_status_off_id'));
                $status = 0;
            }

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    // Это категория / This is category
                    self::$parent_id = self::dataParentId($idx[$i]);
                    $keys = self::dataKeys($idx[$i]);

                    $count_keys = count($keys);
                    for ($x = 0; $x < $count_keys; $x++) {

                        if ((\eMarket\Valid::inPOST('idsx_status_on_key') == 'On')
                                or ( \eMarket\Valid::inPOST('idsx_status_off_key') == 'Off')) {

                            // Это категория / This is category
                            \eMarket\Pdo::action("UPDATE " . TABLE_CATEGORIES . " SET status=? WHERE parent_id=?", [$status, $keys[$x]]);

                            // Это товар / This is product
                            \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET status=? WHERE parent_id=?", [$status, $keys[$x]]);

                            if ($parent_id_real > 0) {
                                self::$parent_id = $parent_id_real;
                            }
                        }
                    }

                    if ((\eMarket\Valid::inPOST('idsx_status_on_key') == 'On')
                            or ( \eMarket\Valid::inPOST('idsx_status_off_key') == 'Off')) {
                        \eMarket\Pdo::action("UPDATE " . TABLE_CATEGORIES . " SET status=? WHERE id=?", [$status, $idx[$i]]);
                    }
                } else {
                    // Это товар / This is product
                    if ((\eMarket\Valid::inPOST('idsx_status_on_key') == 'On')
                            or ( \eMarket\Valid::inPOST('idsx_status_off_key') == 'Off')) {
                        $id_prod = explode('product_', $idx[$i]);
                        \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET status=? WHERE id=?", [$status, $id_prod[1]]);
                    }
                }
            }
        }

        if (is_array(self::$parent_id) == TRUE) {
            self::$parent_id = 0;
        }
    }

    /**
     * Стикеры / Stikers
     */
    private static function stiker() {

        if ((\eMarket\Valid::inPOST('idsx_stikerOn_key') == 'On')
                or ( \eMarket\Valid::inPOST('idsx_stikerOff_key') == 'Off')) {

            $parent_id_real = (int) \eMarket\Valid::inPOST('idsx_real_parent_id');

            if (\eMarket\Valid::inPOST('idsx_stikerOn_key') == 'On') {
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_stiker_on_id'));
                $stiker = \eMarket\Valid::inPOST('stiker');
            }

            if (\eMarket\Valid::inPOST('idsx_stikerOff_key') == 'Off') {
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_stiker_off_id'));
                $stiker = '';
                $stiker_id = \eMarket\Valid::inPOST('stiker');
            }

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    // Это категория / This is category
                    self::$parent_id = self::dataParentId($idx[$i]);
                    $keys = self::dataKeys($idx[$i]);

                    $count_keys = count($keys);
                    for ($x = 0; $x < $count_keys; $x++) {

                        if (\eMarket\Valid::inPOST('idsx_stikerOn_key') == 'On' OR \eMarket\Valid::inPOST('idsx_stikerOff_key') == 'Off') {
                            // Это товар / This is product
                            $stiker_id_array = \eMarket\Pdo::getCol("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($stiker_id_array as $stiker_id_arr) {
                                \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET stiker=? WHERE id=?", [$stiker, $stiker_id_arr]);
                            }

                            if ($parent_id_real > 0) {
                                self::$parent_id = $parent_id_real;
                            }
                        }
                    }
                } else {
                    // Это товар / This is product
                    if (\eMarket\Valid::inPOST('idsx_stikerOn_key') == 'On' OR \eMarket\Valid::inPOST('idsx_stikerOff_key') == 'Off') {
                        $id_prod = explode('product_', $idx[$i]);
                        \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET stiker=? WHERE id=?", [$stiker, $id_prod[1]]);
                    }
                }
            }
        }

        if (is_array(self::$parent_id) == TRUE) {
            self::$parent_id = 0;
        }
    }

    /**
     * Установка parent_id при навигации / parent_id for navigation
     * @param string $idx (идентификатор / identifier)
     */
    public static function dataParentId($idx) {

        self::$parent_id = \eMarket\Pdo::selectPrepare("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", [$idx]);
        $parent_id_up = \eMarket\Pdo::selectPrepare("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", [self::$parent_id]);
        $parent_id_num = \eMarket\Pdo::getColRow("SELECT id FROM " . TABLE_CATEGORIES . " WHERE parent_id=?", [self::$parent_id]);
        if (count($parent_id_num) < 2) {
            self::$parent_id = $parent_id_up;
        }
    }

    /**
     * Ключ категорий / Categories key
     * @param string $idx (идентификатор / identifier)
     * @return array $keys
     */
    public static function dataKeys($idx) {

        $data_cat = \eMarket\Pdo::action("SELECT id, parent_id FROM " . TABLE_CATEGORIES);

        $category = $idx;
        $categories = [];
        $keys[] = $category;

        while ($category = $data_cat->fetch(\PDO::FETCH_ASSOC)) {
            if (in_array($category['parent_id'], $keys)) {
                $categories[$category['parent_id']][] = $category['id'];
                $keys[] = $category['id'];
            }
        }

        return $keys;
    }

    /**
     * Удаление изображений / Delete images
     * @param string $TABLE (название таблицы / table name)
     * @param array $keys (ключи / keys)
     * @param string $path (путь / path)
     */
    private static function deleteImages($TABLE, $keys, $path) {

        if ($path == 'categories') {
            $resize = self::$resize_param;
        }
        if ($path == 'products') {
            $resize = self::$resize_param_product;
        }

        $logo_delete = json_decode(\eMarket\Pdo::getCellFalse("SELECT logo FROM " . $TABLE . " WHERE parent_id=?", [$keys]), 1);
        if (is_countable($logo_delete)) {
            foreach ($logo_delete as $file) {
                // Удаляем файлы
                foreach ($resize as $key => $value) {
                    \eMarket\Func::deleteFile(ROOT . '/uploads/images/' . $path . '/resize_' . $key . '/' . $file);
                }
                \eMarket\Func::deleteFile(ROOT . '/uploads/images/' . $path . '/originals/' . $file);
            }
        }
    }

    /**
     * Добавить товар / Add product
     */
    private static function addProduct() {

        if (\eMarket\Valid::inPOST('add_product')) {

            // Формат даты после Datepicker / Format date after Datepicker
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
                $tax_product_stock = (int) \eMarket\Valid::inPOST('tax_product_stock');
            } else {
                $tax_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('unit_product_stock')) {
                $unit_product_stock = (int) \eMarket\Valid::inPOST('unit_product_stock');
            } else {
                $unit_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('manufacturers_product_stock')) {
                $manufacturers_product_stock = (int) \eMarket\Valid::inPOST('manufacturers_product_stock');
            } else {
                $manufacturers_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('vendor_codes_product_stock')) {
                $vendor_codes_product_stock = (int) \eMarket\Valid::inPOST('vendor_codes_product_stock');
            } else {
                $vendor_codes_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('weight_product_stock')) {
                $weight_product_stock = (int) \eMarket\Valid::inPOST('weight_product_stock');
            } else {
                $weight_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('length_product_stock')) {
                $length_product_stock = (int) \eMarket\Valid::inPOST('length_product_stock');
            } else {
                $length_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('currency_product_stock')) {
                $currency_product_stock = (int) \eMarket\Valid::inPOST('currency_product_stock');
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

            $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                \eMarket\Pdo::action("INSERT INTO " . TABLE_PRODUCTS .
                        " SET id=?, name=?, language=?, parent_id=?, date_added=?, date_available=?, model=?, price=?, currency=?, quantity=?, unit=?, keyword=?, tags=?, description=?, tax=?, manufacturer=?, vendor_code=?, vendor_code_value=?, weight=?, weight_value=?, dimension=?, length=?, width=?, height=?, min_quantity=?, logo=?, discount=?, attributes=?", [
                    $id, \eMarket\Valid::inPOST('name_product_stock_' . $x), lang('#lang_all')[$x], self::$parent_id, date("Y-m-d H:i:s"), $date_available, \eMarket\Valid::inPOST('model_product_stock'), \eMarket\Valid::inPOST('price_product_stock'), $currency_product_stock, \eMarket\Valid::inPOST('quantity_product_stock'), $unit_product_stock, \eMarket\Valid::inPOST('keyword_product_stock_' . $x), \eMarket\Valid::inPOST('tags_product_stock_' . $x), \eMarket\Valid::inPOST('description_product_stock_' . $x),
                    $tax_product_stock, $manufacturers_product_stock, $vendor_codes_product_stock, \eMarket\Valid::inPOST('vendor_code_value_product_stock'), $weight_product_stock, $weight_value_product_stock, $length_product_stock, $value_length_product_stock, $value_width_product_stock, $value_height_product_stock, $min_quantity_product_stock, json_encode([]), json_encode([]), $selected_attributes_product_stock
                ]);
            }

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Редактировать товар / Edit product
     */
    private static function editProduct() {

        if (\eMarket\Valid::inPOST('edit_product')) {

            // Формат даты после Datepicker / Format date after Datepicker
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
                $tax_product_stock = (int) \eMarket\Valid::inPOST('tax_product_stock');
            } else {
                $tax_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('unit_product_stock')) {
                $unit_product_stock = (int) \eMarket\Valid::inPOST('unit_product_stock');
            } else {
                $unit_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('manufacturers_product_stock')) {
                $manufacturers_product_stock = (int) \eMarket\Valid::inPOST('manufacturers_product_stock');
            } else {
                $manufacturers_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('vendor_codes_product_stock')) {
                $vendor_codes_product_stock = (int) \eMarket\Valid::inPOST('vendor_codes_product_stock');
            } else {
                $vendor_codes_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('weight_product_stock')) {
                $weight_product_stock = (int) \eMarket\Valid::inPOST('weight_product_stock');
            } else {
                $weight_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('length_product_stock')) {
                $length_product_stock = (int) \eMarket\Valid::inPOST('length_product_stock');
            } else {
                $length_product_stock = NULL;
            }

            if (\eMarket\Valid::inPOST('currency_product_stock')) {
                $currency_product_stock = (int) \eMarket\Valid::inPOST('currency_product_stock');
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

            for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS .
                        " SET name=?, last_modified=?, date_available=?, model=?, price=?, currency=?, quantity=?, unit=?, keyword=?, tags=?, description=?, tax=?, manufacturer=?, vendor_code=?, vendor_code_value=?, weight=?, weight_value=?, dimension=?, length=?, width=?, height=?, min_quantity=?, attributes=? WHERE id=? AND language=?", [
                    \eMarket\Valid::inPOST('name_product_stock_' . $x), date("Y-m-d H:i:s"), $date_available, \eMarket\Valid::inPOST('model_product_stock'), \eMarket\Valid::inPOST('price_product_stock'), $currency_product_stock, \eMarket\Valid::inPOST('quantity_product_stock'), $unit_product_stock, \eMarket\Valid::inPOST('keyword_product_stock_' . $x), \eMarket\Valid::inPOST('tags_product_stock_' . $x), \eMarket\Valid::inPOST('description_product_stock_' . $x),
                    $tax_product_stock, $manufacturers_product_stock, $vendor_codes_product_stock, \eMarket\Valid::inPOST('vendor_code_value_product_stock'), $weight_product_stock, $weight_value_product_stock, $length_product_stock, $value_length_product_stock, $value_width_product_stock, $value_height_product_stock, $min_quantity_product_stock, $selected_attributes_product_stock, \eMarket\Valid::inPOST('edit_product'), lang('#lang_all')[$x]
                ]);
            }

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

}

?>