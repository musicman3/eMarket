<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Files,
    Func,
    Lang,
    Messages,
    Pdo,
    Valid
};
use eMarket\Admin\Stickers;

/**
 * eMarket Ajax Catalog
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
final class Eac {

    public static $parent_id = 0;
    private static $resize_param = FALSE;
    private static $resize_param_product = FALSE;

    /**
     * Init EAC
     * @param array $resize_param Resize param for categories
     * @param array $resize_param_product Resize param for products
     * @return array [$idsx_real_parent_id, self::$parent_id]
     */
    public static function init($resize_param, $resize_param_product) {

        self::$resize_param = $resize_param;
        self::$resize_param_product = $resize_param_product;

        self::parentIdStart();

        self::addCategory();

        self::editCategory();

        self::addProduct();

        self::editProduct();

        //Image loader for categories (INSERT BEFORE DELETING)
        Files::imgUpload(TABLE_CATEGORIES, 'categories', self::$resize_param);

        //Image loader for products (INSERT BEFORE DELETING)
        Files::imgUploadProduct(TABLE_PRODUCTS, 'products', self::$resize_param_product);

        $idsx_real_parent_id = self::$parent_id; //for sent to JS

        self::delete();

        self::cut();

        self::paste();

        self::status();

        self::initDiscount();

        Stickers::initEac();

        self::sortList();

        return [$idsx_real_parent_id, self::$parent_id];
    }

    /**
     * Discounts init
     */
    private static function initDiscount() {

        $active_modules = Pdo::getAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=?", ['discount', '1']);

        foreach ($active_modules as $module) {
            $namespace = '\eMarket\Core\Modules\Discount\\' . ucfirst($module['name']);
            $namespace::initEac();
        }
    }

    /**
     * Parent_id init
     */
    private static function parentIdStart() {

        self::$parent_id = Valid::inPOST('parent_id');
        if (self::$parent_id == FALSE) {
            self::$parent_id = 0;
        }

        if (Valid::inGET('parent_up')) {
            self::$parent_id = Pdo::getValue("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", [Valid::inGET('parent_up')]);
        }

        if (Valid::inGET('parent_down')) {
            self::$parent_id = Valid::inGET('parent_down');
        }
        
        if (Valid::inPostJson('parent_down')) {
            self::$parent_id = Valid::inPostJson('parent_down');
        }

        if (Valid::inGET('nav_parent_id')) {
            self::$parent_id = Valid::inGET('nav_parent_id');
        }
    }

    /**
     * Sorting
     */
    private static function sortList() {

        if (Valid::inPostJson('ids')) {
            $sort_array_id_ajax = explode(',', Valid::inPostJson('ids'));

            $sort_array_id = Func::deleteEmptyInArray($sort_array_id_ajax);

            $sort_array_category = [];

            foreach ($sort_array_id as $val) {
                $sort_category = Pdo::getValue("SELECT sort_category FROM " . TABLE_CATEGORIES . " WHERE id=? AND language=? ORDER BY id ASC", [
                            $val, lang('#lang_all')[0]
                ]);
                array_push($sort_array_category, $sort_category);
                arsort($sort_array_category); //
            }

            $sort_array_final = array_combine($sort_array_id, $sort_array_category);

            foreach ($sort_array_id as $val) {
                Pdo::action("UPDATE " . TABLE_CATEGORIES . " SET sort_category=? WHERE id=?", [(int) $sort_array_final[$val], (int) $val]);
            }
            Messages::alert('sorting', 'success', lang('action_completed_successfully'), 0, true);
        }
    }

    /**
     * Add category
     */
    private static function addCategory() {

        if (Valid::inPOST('add')) {

            $sort_max = Pdo::getValue("SELECT sort_category FROM " . TABLE_CATEGORIES . " WHERE language=? AND parent_id=? ORDER BY sort_category DESC", [
                        lang('#lang_all')[0], self::$parent_id
            ]);
            $sort_category = intval($sort_max) + 1;

            $id_max = Pdo::getValue("SELECT id FROM " . TABLE_CATEGORIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if (Valid::inPOST('attributes')) {
                $attributes = Valid::inPOST('attributes');
            } else {
                $attributes = json_encode([]);
            }

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("INSERT INTO " . TABLE_CATEGORIES . " SET id=?, name=?, sort_category=?, language=?, parent_id=?, date_added=?, status=?, logo=?, attributes=?", [
                    $id, Valid::inPOST('name_categories_stock_' . $x), $sort_category, lang('#lang_all')[$x], self::$parent_id,
                    date("Y-m-d H:i:s"), 1, json_encode([]), $attributes
                ]);
            }

            Messages::alert('add_category', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit category
     */
    private static function editCategory() {

        if (Valid::inPOST('edit')) {

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("UPDATE " . TABLE_CATEGORIES . " SET name=?, last_modified=?, attributes=? WHERE id=? AND language=?", [
                    Valid::inPOST('name_categories_stock_' . $x), date("Y-m-d H:i:s"), Valid::inPOST('attributes'), Valid::inPOST('edit'),
                    lang('#lang_all')[$x]
                ]);
            }

            Messages::alert('edit_category', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete category
     */
    private static function delete() {

        if (Valid::inPostJson('delete')) {

            $idx = Func::deleteEmptyInArray(Valid::inPostJson('delete'));

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'products') {
                    // This is category
                    self::$parent_id = self::dataParentId($idx[$i]);
                    $keys = self::dataKeys($idx[$i]);

                    $count_keys = count($keys);
                    for ($x = 0; $x < $count_keys; $x++) {

                        // Removing product and images
                        self::deleteImages(TABLE_PRODUCTS, $keys[$x], 'products');
                        Pdo::action("DELETE FROM " . TABLE_PRODUCTS . " WHERE parent_id=?", [$keys[$x]]);

                        // Removing subcategories and images
                        self::deleteImages(TABLE_CATEGORIES, $keys[$x], 'categories');
                        Pdo::action("DELETE FROM " . TABLE_CATEGORIES . " WHERE parent_id=?", [$keys[$x]]);
                    }

                    // Removing general category
                    Pdo::action("DELETE FROM " . TABLE_CATEGORIES . " WHERE id=?", [$idx[$i]]);

                    // Buffer empty
                    if (isset($_SESSION['buffer']['cat']) && $_SESSION['buffer']['cat'] != FALSE) {
                        $_SESSION['buffer']['cat'] = Func::deleteValInArray($_SESSION['buffer']['cat'], [$idx[$i]]);
                        if (count($_SESSION['buffer']['cat']) == 0) {
                            unset($_SESSION['buffer']['cat']);
                        }
                    }
                } else {
                    // This is product
                    $id_prod = explode('products_', $idx[$i]);
                    //Удаляем основной товар / Removing general product
                    Pdo::action("DELETE FROM " . TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);

                    // Buffer empty
                    if (isset($_SESSION['buffer']['prod']) && $_SESSION['buffer']['prod'] != FALSE) {
                        $_SESSION['buffer']['prod'] = Func::deleteValInArray($_SESSION['buffer']['prod'], [$id_prod[1]]);
                        if (count($_SESSION['buffer']['prod']) == 0) {
                            unset($_SESSION['buffer']['prod']);
                        }
                    }
                }

                Messages::alert('delete', 'success', lang('action_completed_successfully'));
            }
        }

        if (is_array(self::$parent_id) == TRUE) {
            self::$parent_id = 0;
        }
    }

    /**
     * Cut category
     */
    private static function cut() {

        if (Valid::inPostJson('idsx_cut_marker') == 'cut') {
            unset($_SESSION['buffer']);
        }

        if ((Valid::inPostJson('idsx_cut_key') == 'cut')) {
            $idx = Func::deleteEmptyInArray(Valid::inPostJson('idsx_cut_id'));

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {

                $parent_id_real = (int) Valid::inPostJson('idsx_real_parent_id');
                self::$parent_id = self::dataParentId($idx[$i]);

                if (Valid::inPostJson('idsx_cut_key') == 'cut') {
                    // This is category
                    if (strstr($idx[$i], '_', true) != 'products') {
                        if (!isset($_SESSION['buffer']['cat'])) {
                            $_SESSION['buffer']['cat'] = [];
                        }
                        array_push($_SESSION['buffer']['cat'], $idx[$i]);
                        if ($parent_id_real > 0) {
                            self::$parent_id = $parent_id_real;
                        }
                    } else {
                        // This is product
                        if (!isset($_SESSION['buffer']['prod'])) {
                            $_SESSION['buffer']['prod'] = [];
                        }
                        $id_prod = explode('products_', $idx[$i]);
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
     * Paste category
     */
    private static function paste() {

        if (Valid::inPostJson('idsx_paste_key') == 'paste' && isset($_SESSION['buffer']) == TRUE) {

            $parent_id_real = (int) Valid::inPostJson('idsx_real_parent_id');
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
                // This is category
                if (isset($_SESSION['buffer']['cat'][$buf]) && count($_SESSION['buffer']['cat']) > 0) {
                    $sort_max = Pdo::getValue("SELECT sort_category FROM " . TABLE_CATEGORIES . " WHERE language=? AND parent_id=? ORDER BY sort_category DESC", [
                                lang('#lang_all')[0], $parent_id_real
                    ]);
                    $sort_category = intval($sort_max) + 1;
                    Pdo::action("UPDATE " . TABLE_CATEGORIES . " SET parent_id=?, sort_category=? WHERE id=?", [
                        $parent_id_real, $sort_category, $_SESSION['buffer']['cat'][$buf]
                    ]);
                }

                if (isset($_SESSION['buffer']['prod'][$buf]) && count($_SESSION['buffer']['prod']) > 0) {
                    // This is product
                    Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET parent_id=?, attributes=? WHERE id=?", [
                        $parent_id_real, json_encode([]), $_SESSION['buffer']['prod'][$buf]
                    ]);
                }
            }
            unset($_SESSION['buffer']); // Buffer empty
            if ($parent_id_real > 0) {
                self::$parent_id = $parent_id_real; //
            }
            
            Messages::alert('paste', 'success', lang('action_completed_successfully'), 0, true);

        }

        if (is_array(self::$parent_id) == TRUE) {
            self::$parent_id = 0;
        }
    }

    /**
     * Categories status
     */
    private static function status() {

        if ((Valid::inPostJson('idsx_status_on_key') == 'On')
                or (Valid::inPostJson('idsx_status_off_key') == 'Off')) {

            $parent_id_real = (int) Valid::inPostJson('idsx_real_parent_id');

            if (Valid::inPostJson('idsx_status_on_key') == 'On') {
                $idx = Func::deleteEmptyInArray(Valid::inPostJson('idsx_status_on_id'));
                $status = 1;
            }

            if (Valid::inPostJson('idsx_status_off_key') == 'Off') {
                $idx = Func::deleteEmptyInArray(Valid::inPostJson('idsx_status_off_id'));
                $status = 0;
            }

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'products') {
                    // This is category
                    self::$parent_id = self::dataParentId($idx[$i]);
                    $keys = self::dataKeys($idx[$i]);

                    $count_keys = count($keys);
                    for ($x = 0; $x < $count_keys; $x++) {

                        if ((Valid::inPostJson('idsx_status_on_key') == 'On')
                                or (Valid::inPostJson('idsx_status_off_key') == 'Off')) {

                            // This is category
                            Pdo::action("UPDATE " . TABLE_CATEGORIES . " SET status=? WHERE parent_id=?", [$status, $keys[$x]]);

                            // This is product
                            Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET status=? WHERE parent_id=?", [$status, $keys[$x]]);

                            if ($parent_id_real > 0) {
                                self::$parent_id = $parent_id_real;
                            }
                            Messages::alert('status', 'success', lang('action_completed_successfully'), 0, true);
                        }
                    }

                    if ((Valid::inPostJson('idsx_status_on_key') == 'On')
                            or (Valid::inPostJson('idsx_status_off_key') == 'Off')) {
                        Pdo::action("UPDATE " . TABLE_CATEGORIES . " SET status=? WHERE id=?", [$status, $idx[$i]]);
                        Messages::alert('status', 'success', lang('action_completed_successfully'), 0, true);
                    }
                } else {
                    // This is product
                    if ((Valid::inPostJson('idsx_status_on_key') == 'On')
                            or (Valid::inPostJson('idsx_status_off_key') == 'Off')) {
                        $id_prod = explode('products_', $idx[$i]);
                        Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET status=? WHERE id=?", [$status, $id_prod[1]]);
                        Messages::alert('status', 'success', lang('action_completed_successfully'), 0, true);
                    }
                }
            }
        }

        if (is_array(self::$parent_id) == TRUE) {
            self::$parent_id = 0;
        }
    }

    /**
     * Parent_id for navigation
     * @param string $idx Identifier
     */
    public static function dataParentId($idx) {

        self::$parent_id = Pdo::getValue("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", [$idx]);
        $parent_id_up = Pdo::getValue("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", [self::$parent_id]);
        $parent_id_num = Pdo::getIndex("SELECT id FROM " . TABLE_CATEGORIES . " WHERE parent_id=?", [self::$parent_id]);
        if (count($parent_id_num) < 2) {
            self::$parent_id = $parent_id_up;
        }
    }

    /**
     * Categories key
     * @param string $idx (Identifier
     * @return array $keys
     */
    public static function dataKeys($idx) {

        $data_cat = Pdo::action("SELECT id, parent_id FROM " . TABLE_CATEGORIES);

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
     * Delete images
     * @param string $TABLE Table name
     * @param array $keys Keys
     * @param string $path Path
     */
    private static function deleteImages($TABLE, $keys, $path) {

        if ($path == 'categories') {
            $resize = self::$resize_param;
        }
        if ($path == 'products') {
            $resize = self::$resize_param_product;
        }

        $logo_delete = json_decode(Pdo::getValue("SELECT logo FROM " . $TABLE . " WHERE parent_id=?", [$keys]), 1);
        if (is_countable($logo_delete)) {
            foreach ($logo_delete as $file) {
                // Delete
                foreach ($resize as $key => $value) {
                    Func::deleteFile(ROOT . '/uploads/images/' . $path . '/resize_' . $key . '/' . $file);
                }
                Func::deleteFile(ROOT . '/uploads/images/' . $path . '/originals/' . $file);
            }
        }
    }

    /**
     * Add product
     */
    private static function addProduct() {

        if (Valid::inPOST('add_product')) {

            // Format date after Datepicker
            if (Valid::inPOST('date_available_product_stock')) {
                $date_available = date('Y-m-d', strtotime(Valid::inPOST('date_available_product_stock')));
            } else {

                $date_available = NULL;
            }

            if (Valid::inPOST('view_product_stock')) {
                $view_product = 1;
            } else {
                $view_product = 0;
            }

            if (Valid::inPOST('tax_product_stock')) {
                $tax_product_stock = (int) Valid::inPOST('tax_product_stock');
            } else {
                $tax_product_stock = NULL;
            }

            if (Valid::inPOST('unit_product_stock')) {
                $unit_product_stock = (int) Valid::inPOST('unit_product_stock');
            } else {
                $unit_product_stock = NULL;
            }

            if (Valid::inPOST('manufacturers_product_stock')) {
                $manufacturers_product_stock = (int) Valid::inPOST('manufacturers_product_stock');
            } else {
                $manufacturers_product_stock = NULL;
            }

            if (Valid::inPOST('vendor_codes_product_stock')) {
                $vendor_codes_product_stock = (int) Valid::inPOST('vendor_codes_product_stock');
            } else {
                $vendor_codes_product_stock = NULL;
            }

            if (Valid::inPOST('weight_product_stock')) {
                $weight_product_stock = (int) Valid::inPOST('weight_product_stock');
            } else {
                $weight_product_stock = NULL;
            }

            if (Valid::inPOST('length_product_stock')) {
                $length_product_stock = (int) Valid::inPOST('length_product_stock');
            } else {
                $length_product_stock = NULL;
            }

            if (Valid::inPOST('currency_product_stock')) {
                $currency_product_stock = (int) Valid::inPOST('currency_product_stock');
            } else {
                $currency_product_stock = NULL;
            }

            if (Valid::inPOST('weight_value_product_stock')) {
                $weight_value_product_stock = Valid::inPOST('weight_value_product_stock');
            } else {
                $weight_value_product_stock = NULL;
            }

            if (Valid::inPOST('value_length_product_stock')) {
                $value_length_product_stock = Valid::inPOST('value_length_product_stock');
            } else {
                $value_length_product_stock = NULL;
            }

            if (Valid::inPOST('value_width_product_stock')) {
                $value_width_product_stock = Valid::inPOST('value_width_product_stock');
            } else {
                $value_width_product_stock = NULL;
            }

            if (Valid::inPOST('value_height_product_stock')) {
                $value_height_product_stock = Valid::inPOST('value_height_product_stock');
            } else {
                $value_height_product_stock = NULL;
            }

            if (Valid::inPOST('min_quantity_product_stock')) {
                $min_quantity_product_stock = Valid::inPOST('min_quantity_product_stock');
            } else {
                $min_quantity_product_stock = NULL;
            }

            if (Valid::inPOST('selected_attributes')) {
                $selected_attributes_product_stock = Valid::inPOST('selected_attributes');
            } else {
                $selected_attributes_product_stock = json_encode([]);
            }

            $id_max = Pdo::getValue("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("INSERT INTO " . TABLE_PRODUCTS .
                        " SET id=?, name=?, language=?, parent_id=?, date_added=?, date_available=?, model=?, price=?, currency=?, quantity=?, "
                        . "unit=?, keyword=?, tags=?, description=?, tax=?, manufacturer=?, vendor_code=?, vendor_code_value=?, weight=?, "
                        . "weight_value=?, dimension=?, length=?, width=?, height=?, min_quantity=?, logo=?, discount=?, attributes=?", [
                    $id, Valid::inPOST('name_product_stock_' . $x), lang('#lang_all')[$x], self::$parent_id, date("Y-m-d H:i:s"),
                    $date_available, Valid::inPOST('model_product_stock'), Valid::inPOST('price_product_stock'),
                    $currency_product_stock, Valid::inPOST('quantity_product_stock'), $unit_product_stock,
                    Valid::inPOST('keyword_product_stock_' . $x), Valid::inPOST('tags_product_stock_' . $x),
                    Valid::inPOST('description_product_stock_' . $x), $tax_product_stock, $manufacturers_product_stock,
                    $vendor_codes_product_stock, Valid::inPOST('vendor_code_value_product_stock'), $weight_product_stock,
                    $weight_value_product_stock, $length_product_stock, $value_length_product_stock, $value_width_product_stock,
                    $value_height_product_stock, $min_quantity_product_stock, json_encode([]), json_encode([]),
                    $selected_attributes_product_stock
                ]);
            }

            Messages::alert('add_product', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit product
     */
    private static function editProduct() {

        if (Valid::inPOST('edit_product')) {

            // Format date after Datepicker
            if (Valid::inPOST('date_available_product_stock')) {
                $date_available = date('Y-m-d', strtotime(Valid::inPOST('date_available_product_stock')));
            } else {
                $date_available = NULL;
            }

            if (Valid::inPOST('view_product_stock')) {
                $view_product = 1;
            } else {
                $view_product = 0;
            }

            if (Valid::inPOST('tax_product_stock')) {
                $tax_product_stock = (int) Valid::inPOST('tax_product_stock');
            } else {
                $tax_product_stock = NULL;
            }

            if (Valid::inPOST('unit_product_stock')) {
                $unit_product_stock = (int) Valid::inPOST('unit_product_stock');
            } else {
                $unit_product_stock = NULL;
            }

            if (Valid::inPOST('manufacturers_product_stock')) {
                $manufacturers_product_stock = (int) Valid::inPOST('manufacturers_product_stock');
            } else {
                $manufacturers_product_stock = NULL;
            }

            if (Valid::inPOST('vendor_codes_product_stock')) {
                $vendor_codes_product_stock = (int) Valid::inPOST('vendor_codes_product_stock');
            } else {
                $vendor_codes_product_stock = NULL;
            }

            if (Valid::inPOST('weight_product_stock')) {
                $weight_product_stock = (int) Valid::inPOST('weight_product_stock');
            } else {
                $weight_product_stock = NULL;
            }

            if (Valid::inPOST('length_product_stock')) {
                $length_product_stock = (int) Valid::inPOST('length_product_stock');
            } else {
                $length_product_stock = NULL;
            }

            if (Valid::inPOST('currency_product_stock')) {
                $currency_product_stock = (int) Valid::inPOST('currency_product_stock');
            } else {
                $currency_product_stock = NULL;
            }

            if (Valid::inPOST('weight_value_product_stock')) {
                $weight_value_product_stock = Valid::inPOST('weight_value_product_stock');
            } else {
                $weight_value_product_stock = NULL;
            }

            if (Valid::inPOST('value_length_product_stock')) {
                $value_length_product_stock = Valid::inPOST('value_length_product_stock');
            } else {
                $value_length_product_stock = NULL;
            }

            if (Valid::inPOST('value_width_product_stock')) {
                $value_width_product_stock = Valid::inPOST('value_width_product_stock');
            } else {
                $value_width_product_stock = NULL;
            }

            if (Valid::inPOST('value_height_product_stock')) {
                $value_height_product_stock = Valid::inPOST('value_height_product_stock');
            } else {
                $value_height_product_stock = NULL;
            }

            if (Valid::inPOST('min_quantity_product_stock')) {
                $min_quantity_product_stock = Valid::inPOST('min_quantity_product_stock');
            } else {
                $min_quantity_product_stock = NULL;
            }

            if (Valid::inPOST('selected_attributes')) {
                $selected_attributes_product_stock = Valid::inPOST('selected_attributes');
            } else {
                $selected_attributes_product_stock = json_encode([]);
            }

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET name=?, last_modified=?, date_available=?, model=?, price=?, currency=?, quantity=?,"
                        . " unit=?, keyword=?, tags=?, description=?, tax=?, manufacturer=?, vendor_code=?, vendor_code_value=?, weight=?, "
                        . "weight_value=?, dimension=?, length=?, width=?, height=?, min_quantity=?, attributes=? WHERE id=? AND language=?", [
                    Valid::inPOST('name_product_stock_' . $x), date("Y-m-d H:i:s"), $date_available,
                    Valid::inPOST('model_product_stock'), Valid::inPOST('price_product_stock'), $currency_product_stock,
                    Valid::inPOST('quantity_product_stock'), $unit_product_stock, Valid::inPOST('keyword_product_stock_' . $x),
                    Valid::inPOST('tags_product_stock_' . $x), Valid::inPOST('description_product_stock_' . $x),
                    $tax_product_stock, $manufacturers_product_stock, $vendor_codes_product_stock,
                    Valid::inPOST('vendor_code_value_product_stock'), $weight_product_stock, $weight_value_product_stock,
                    $length_product_stock, $value_length_product_stock, $value_width_product_stock, $value_height_product_stock,
                    $min_quantity_product_stock, $selected_attributes_product_stock, Valid::inPOST('edit_product'), lang('#lang_all')[$x]
                ]);
            }

            Messages::alert('edit_product', 'success', lang('action_completed_successfully'));
        }
    }

}
