<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Cache,
    Clock\SystemClock,
    Files,
    Func,
    Lang,
    Messages,
    Valid
};
use eMarket\Admin\Stickers;
use Cruder\Cruder;

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

    public $db;
    public static $parent_id = 0;
    private static $resize_param = FALSE;
    private static $resize_param_product = FALSE;
    private static $date_available = NULL;
    private static $tax = NULL;
    private static $unit = NULL;
    private static $manufacturers = NULL;
    private static $vendor_code = NULL;
    private static $weight = NULL;
    private static $length = NULL;
    private static $currency = NULL;
    private static $weight_value = NULL;
    private static $length_value = NULL;
    private static $width_value = NULL;
    private static $height_value = NULL;
    private static $min_quantity = NULL;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->db = new Cruder();
        $this->parentIdStart();
        $this->addCategory();
        $this->editCategory();
        $this->addProduct();
        $this->editProduct();
        $this->sortList();
    }

    /**
     * Init EAC
     * @param array $resize_param Resize param for categories
     * @param array $resize_param_product Resize param for products
     * @return array [$idsx_real_parent_id, self::$parent_id]
     */
    public function init(array $resize_param, array $resize_param_product): array {

        self::$resize_param = $resize_param;
        self::$resize_param_product = $resize_param_product;

        //Image loader for categories (INSERT BEFORE DELETING)
        Files::imgUpload(TABLE_CATEGORIES, 'categories', self::$resize_param);
        //Image loader for products (INSERT BEFORE DELETING)
        Files::imgUploadProduct(TABLE_PRODUCTS, 'products', self::$resize_param_product);

        $idsx_real_parent_id = self::$parent_id; //for sent to JS

        $this->delete();
        $this->cut();
        $this->paste();
        $this->status();
        $this->initDiscount();
        $stickers = new Stickers();
        $stickers->initEac();

        return [$idsx_real_parent_id, self::$parent_id];
    }

    /**
     * Discounts init
     */
    private function initDiscount(): void {

        $active_modules = $this->db
                ->read(TABLE_MODULES)
                ->selectAssoc('*')
                ->where('type=', 'discount')
                ->and('active=', '1')
                ->save();

        foreach ($active_modules as $module) {
            $namespace = '\eMarket\Core\Modules\Discount\\' . ucfirst($module['name']);
            $namespace::initEac();
        }
    }

    /**
     * Parent_id init
     */
    private function parentIdStart(): void {

        self::$parent_id = Valid::inPOST('parent_id');
        if (self::$parent_id == FALSE) {
            self::$parent_id = 0;
        }

        if (Valid::inGET('parent_up')) {
            self::$parent_id = $this->db
                    ->read(TABLE_CATEGORIES)
                    ->selectValue('parent_id')
                    ->where('id=', Valid::inGET('parent_up'))
                    ->save();
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
    private function sortList(): void {

        if (Valid::inPostJson('ids')) {
            $sort_array_id_ajax = explode(',', Valid::inPostJson('ids'));

            $sort_array_id = Func::deleteEmptyInArray($sort_array_id_ajax);

            $sort_array_category = [];

            foreach ($sort_array_id as $val) {

                $sort_category = $this->db
                        ->read(TABLE_CATEGORIES)
                        ->selectValue('sort_category')
                        ->where('id=', $val)
                        ->and('language=', lang('#lang_all')[0])
                        ->orderByAsc('id')
                        ->save();

                array_push($sort_array_category, $sort_category);
                arsort($sort_array_category);
            }

            $sort_array_final = array_combine($sort_array_id, $sort_array_category);

            foreach ($sort_array_id as $val) {

                $this->db
                        ->update(TABLE_CATEGORIES)
                        ->set('sort_category', (int) $sort_array_final[$val])
                        ->where('id=', (int) $val)
                        ->save();
            }
            Messages::alert('sorting', 'success', lang('action_completed_successfully'), 0, true);
        }
    }

    /**
     * Add category
     */
    private function addCategory(): void {

        if (Valid::inPOST('add')) {

            $sort_max = $this->db
                    ->read(TABLE_CATEGORIES)
                    ->selectValue('sort_category')
                    ->where('language=', lang('#lang_all')[0])
                    ->and('parent_id=', self::$parent_id)
                    ->orderByDesc('sort_category')
                    ->save();

            $sort_category = intval($sort_max) + 1;

            $id_max = $this->db
                    ->read(TABLE_CATEGORIES)
                    ->selectValue('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id = intval($id_max) + 1;

            if (Valid::inPOST('attributes')) {
                $attributes = Valid::inPOST('attributes');
            } else {
                $attributes = json_encode([]);
            }

            for ($x = 0; $x < Lang::$count; $x++) {

                $this->db
                        ->create(TABLE_CATEGORIES)
                        ->set('id', $id)
                        ->set('name', Valid::inPOST('name_categories_stock_' . $x))
                        ->set('sort_category', $sort_category)
                        ->set('language', lang('#lang_all')[$x])
                        ->set('parent_id', self::$parent_id)
                        ->set('date_added', SystemClock::nowSqlDateTime())
                        ->set('status', 1)
                        ->set('logo', json_encode([]))
                        ->set('attributes', $attributes)
                        ->save();
            }

            Messages::alert('add_category', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit category
     */
    private function editCategory(): void {

        if (Valid::inPOST('edit')) {

            for ($x = 0; $x < Lang::$count; $x++) {

                $this->db
                        ->update(TABLE_CATEGORIES)
                        ->set('name', Valid::inPOST('name_categories_stock_' . $x))
                        ->set('last_modified', SystemClock::nowSqlDateTime())
                        ->set('attributes', Valid::inPOST('attributes'))
                        ->where('id=', Valid::inPOST('edit'))
                        ->and('language=', lang('#lang_all')[$x])
                        ->save();
            }

            Messages::alert('edit_category', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete category
     */
    private function delete(): void {

        if (Valid::inPostJson('delete')) {

            $idx = Func::deleteEmptyInArray(Valid::inPostJson('delete'));

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'products') {
                    $id_cat = explode('category_', $idx[$i])[1];
                    // This is category
                    self::$parent_id = self::dataParentId($id_cat);
                    $keys = self::dataKeys($id_cat);

                    $count_keys = count($keys);
                    for ($x = 0; $x < $count_keys; $x++) {
                        // Removing product and images
                        $this->deleteImages(TABLE_PRODUCTS, $keys[$x], 'products');
                        $this->db
                                ->delete(TABLE_PRODUCTS)
                                ->where('parent_id=', $keys[$x])
                                ->save();

                        // Removing subcategories and images
                        $this->deleteImages(TABLE_CATEGORIES, $keys[$x], 'categories');
                        $this->db
                                ->delete(TABLE_CATEGORIES)
                                ->where('parent_id=', $keys[$x])
                                ->save();
                    }

                    // Removing general category
                    $this->db
                            ->delete(TABLE_CATEGORIES)
                            ->where('id=', $id_cat)
                            ->save();

                    // Buffer empty
                    if (isset($_SESSION['buffer']['cat']) && $_SESSION['buffer']['cat'] != FALSE) {
                        $_SESSION['buffer']['cat'] = Func::deleteValInArray($_SESSION['buffer']['cat'], [$id_cat]);
                        if (count($_SESSION['buffer']['cat']) == 0) {
                            unset($_SESSION['buffer']['cat']);
                        }
                    }

                    $Cache = new Cache();
                    $Cache->clear();
                } else {
                    // This is product
                    $id_prod = explode('products_', $idx[$i])[1];
                    //Removing general product
                    $this->db
                            ->delete(TABLE_PRODUCTS)
                            ->where('id=', $id_prod)
                            ->save();

                    // Buffer empty
                    if (isset($_SESSION['buffer']['prod']) && $_SESSION['buffer']['prod'] != FALSE) {
                        $_SESSION['buffer']['prod'] = Func::deleteValInArray($_SESSION['buffer']['prod'], [$id_prod]);
                        if (count($_SESSION['buffer']['prod']) == 0) {
                            unset($_SESSION['buffer']['prod']);
                        }
                    }

                    $Cache = new Cache();
                    $Cache->deleteItem('core.new_products');
                    $Cache->deleteItem('core.products_' . $id_prod);
                }

                Messages::alert('delete', 'success', lang('action_completed_successfully'), 0, true);
            }
        }

        if (is_array(self::$parent_id) == TRUE) {
            self::$parent_id = 0;
        }
    }

    /**
     * Cut category
     */
    private function cut(): void {

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
                        $id_cat = explode('category_', $idx[$i])[1];
                        if (!isset($_SESSION['buffer']['cat'])) {
                            $_SESSION['buffer']['cat'] = [];
                        }
                        array_push($_SESSION['buffer']['cat'], $id_cat);
                        if ($parent_id_real > 0) {
                            self::$parent_id = $parent_id_real;
                        }
                    } else {
                        // This is product
                        if (!isset($_SESSION['buffer']['prod'])) {
                            $_SESSION['buffer']['prod'] = [];
                        }
                        $id_prod = explode('products_', $idx[$i])[1];
                        array_push($_SESSION['buffer']['prod'], $id_prod);
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
    private function paste(): void {

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

                    $sort_max = $this->db
                            ->read(TABLE_CATEGORIES)
                            ->selectValue('sort_category')
                            ->where('language=', lang('#lang_all')[0])
                            ->and('parent_id=', $parent_id_real)
                            ->orderByDesc('sort_category')
                            ->save();

                    $sort_category = intval($sort_max) + 1;

                    $this->db
                            ->update(TABLE_CATEGORIES)
                            ->set('parent_id', $parent_id_real)
                            ->set('sort_category', $sort_category)
                            ->where('id=', $_SESSION['buffer']['cat'][$buf])
                            ->save();
                }

                if (isset($_SESSION['buffer']['prod'][$buf]) && count($_SESSION['buffer']['prod']) > 0) {
                    // This is product
                    $this->db
                            ->update(TABLE_PRODUCTS)
                            ->set('parent_id', $parent_id_real)
                            ->set('attributes', json_encode([]))
                            ->where('id=', $_SESSION['buffer']['prod'][$buf])
                            ->save();
                }

                $Cache = new Cache();
                $Cache->clear();
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
    private function status(): void {

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
                    $id_cat = explode('category_', $idx[$i])[1];
                    self::$parent_id = self::dataParentId($id_cat);
                    $keys = self::dataKeys($id_cat);

                    $count_keys = count($keys);
                    for ($x = 0; $x < $count_keys; $x++) {

                        if ((Valid::inPostJson('idsx_status_on_key') == 'On')
                                or (Valid::inPostJson('idsx_status_off_key') == 'Off')) {

                            // This is category
                            $this->db
                                    ->update(TABLE_CATEGORIES)
                                    ->set('status', $status)
                                    ->where('parent_id=', $keys[$x])
                                    ->save();

                            // This is product
                            $this->db
                                    ->update(TABLE_PRODUCTS)
                                    ->set('status', $status)
                                    ->where('parent_id=', $keys[$x])
                                    ->save();

                            if ($parent_id_real > 0) {
                                self::$parent_id = $parent_id_real;
                            }
                        }
                    }

                    if ((Valid::inPostJson('idsx_status_on_key') == 'On')
                            or (Valid::inPostJson('idsx_status_off_key') == 'Off')) {

                        $this->db
                                ->update(TABLE_CATEGORIES)
                                ->set('status', $status)
                                ->where('id=', $id_cat)
                                ->save();
                    }

                    $Cache = new Cache();
                    $Cache->clear();
                } else {
                    // This is product
                    if ((Valid::inPostJson('idsx_status_on_key') == 'On')
                            or (Valid::inPostJson('idsx_status_off_key') == 'Off')) {

                        $id_prod = explode('products_', $idx[$i])[1];
                        $this->db
                                ->update(TABLE_PRODUCTS)
                                ->set('status', $status)
                                ->where('id=', $id_prod)
                                ->save();

                        $Cache = new Cache();
                        $Cache->deleteItem('core.new_products');
                        $Cache->deleteItem('core.products_' . $id_prod);
                    }
                }

                Messages::alert('status', 'success', lang('action_completed_successfully'), 0, true);
            }
        }

        if (is_array(self::$parent_id) == TRUE) {
            self::$parent_id = 0;
        }
    }

    /**
     * Parent_id for navigation
     * @param string|int $idx Identifier
     */
    public static function dataParentId(string|int $idx): void {

        $db = new Cruder();

        self::$parent_id = $db
                ->read(TABLE_CATEGORIES)
                ->selectValue('parent_id')
                ->where('id=', $idx)
                ->save();

        $parent_id_up = $db
                ->read(TABLE_CATEGORIES)
                ->selectValue('parent_id')
                ->where('id=', self::$parent_id)
                ->save();

        $parent_id_num = $db
                ->read(TABLE_CATEGORIES)
                ->selectIndex('id')
                ->where('parent_id=', self::$parent_id)
                ->save();

        if (count($parent_id_num) < 2) {
            self::$parent_id = $parent_id_up;
        }
    }

    /**
     * Categories key
     * @param string|int $category Identifier $idx
     * @return array $keys
     */
    public static function dataKeys(string|int $category): array {

        $db = new Cruder();
        $data_cat = $db
                ->read(TABLE_CATEGORIES)
                ->selectAssoc('id, parent_id')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        $categories = [];
        $keys[] = $category;

        foreach ($data_cat as $value) {
            if (in_array($value['parent_id'], $keys)) {
                $categories[$value['parent_id']][] = $value['id'];
                $keys[] = $value['id'];
            }
        }

        return $keys;
    }

    /**
     * Delete images
     * @param string $TABLE Table name
     * @param string|int $keys Keys
     * @param string $path Path
     */
    private function deleteImages(string $TABLE, string|int $keys, string $path): void {

        if ($path == 'categories') {
            $resize = self::$resize_param;
        }
        if ($path == 'products') {
            $resize = self::$resize_param_product;
        }

        $data = $this->db
                ->read($TABLE)
                ->selectValue('logo')
                ->where('parent_id=', $keys)
                ->save();

        $logo_delete = true;
        if ($data) {
            $logo_delete = json_decode($data, true);
        }
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
    private function addProduct(): void {

        if (Valid::inPOST('add_product')) {

            // Format date after Datepicker
            if (Valid::inPOST('date_available_product_stock')) {
                self::$date_available = SystemClock::getSqlDate(Valid::inPOST('date_available_product_stock'));
            }

            if (Valid::inPOST('tax_product_stock')) {
                self::$tax = (int) Valid::inPOST('tax_product_stock');
            }

            if (Valid::inPOST('unit_product_stock')) {
                self::$unit = (int) Valid::inPOST('unit_product_stock');
            }

            if (Valid::inPOST('manufacturers_product_stock')) {
                self::$manufacturers = (int) Valid::inPOST('manufacturers_product_stock');
            }

            if (Valid::inPOST('vendor_codes_product_stock')) {
                self::$vendor_code = (int) Valid::inPOST('vendor_codes_product_stock');
            }

            if (Valid::inPOST('weight_product_stock')) {
                self::$weight = (int) Valid::inPOST('weight_product_stock');
            }

            if (Valid::inPOST('length_product_stock')) {
                self::$length = (int) Valid::inPOST('length_product_stock');
            }

            if (Valid::inPOST('currency_product_stock')) {
                self::$currency = (int) Valid::inPOST('currency_product_stock');
            }

            if (Valid::inPOST('weight_value_product_stock')) {
                self::$weight_value = Valid::inPOST('weight_value_product_stock');
            }

            if (Valid::inPOST('value_length_product_stock')) {
                self::$length_value = Valid::inPOST('value_length_product_stock');
            }

            if (Valid::inPOST('value_width_product_stock')) {
                self::$width_value = Valid::inPOST('value_width_product_stock');
            }

            if (Valid::inPOST('value_height_product_stock')) {
                self::$height_value = Valid::inPOST('value_height_product_stock');
            }

            if (Valid::inPOST('min_quantity_product_stock')) {
                self::$min_quantity = Valid::inPOST('min_quantity_product_stock');
            }

            $selected_attributes = json_encode([]);
            if (Valid::inPOST('selected_attributes')) {
                $selected_attributes = Valid::inPOST('selected_attributes');
            }

            $id_max = $this->db
                    ->read(TABLE_PRODUCTS)
                    ->selectValue('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id = intval($id_max) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {

                $this->db
                        ->create(TABLE_PRODUCTS)
                        ->set('id', $id)
                        ->set('name', Valid::inPOST('name_product_stock_' . $x))
                        ->set('language', lang('#lang_all')[$x])
                        ->set('parent_id', self::$parent_id)
                        ->set('date_added', SystemClock::nowSqlDateTime())
                        ->set('date_available', self::$date_available)
                        ->set('model', Valid::inPOST('model_product_stock'))
                        ->set('price', Valid::inPOST('price_product_stock'))
                        ->set('currency', self::$currency)
                        ->set('quantity', Valid::inPOST('quantity_product_stock'))
                        ->set('unit', self::$unit)
                        ->set('keyword', Valid::inPOST('keyword_product_stock_' . $x))
                        ->set('tags', Valid::inPOST('tags_product_stock_' . $x))
                        ->set('description', Valid::inPOST('description_product_stock_' . $x))
                        ->set('tax', self::$tax)
                        ->set('manufacturer', self::$manufacturers)
                        ->set('vendor_code', self::$vendor_code)
                        ->set('vendor_code_value', Valid::inPOST('vendor_code_value_product_stock'))
                        ->set('weight', self::$weight)
                        ->set('weight_value', self::$weight_value)
                        ->set('dimension', self::$length)
                        ->set('length', self::$length_value)
                        ->set('width', self::$width_value)
                        ->set('height', self::$height_value)
                        ->set('min_quantity', self::$min_quantity)
                        ->set('logo', json_encode([]))
                        ->set('discount', json_encode([]))
                        ->set('attributes', $selected_attributes)
                        ->save();
            }

            $Cache = new Cache();
            $Cache->deleteItem('core.new_products');

            Messages::alert('add_product', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit product
     */
    private function editProduct(): void {

        if (Valid::inPOST('edit_product')) {

            // Format date after Datepicker
            if (Valid::inPOST('date_available_product_stock')) {
                self::$date_available = SystemClock::getSqlDate(Valid::inPOST('date_available_product_stock'));
            }

            if (Valid::inPOST('tax_product_stock')) {
                self::$tax = (int) Valid::inPOST('tax_product_stock');
            }

            if (Valid::inPOST('unit_product_stock')) {
                self::$unit = (int) Valid::inPOST('unit_product_stock');
            }

            if (Valid::inPOST('manufacturers_product_stock')) {
                self::$manufacturers = (int) Valid::inPOST('manufacturers_product_stock');
            }

            if (Valid::inPOST('vendor_codes_product_stock')) {
                self::$vendor_code = (int) Valid::inPOST('vendor_codes_product_stock');
            }

            if (Valid::inPOST('weight_product_stock')) {
                self::$weight = (int) Valid::inPOST('weight_product_stock');
            }

            if (Valid::inPOST('length_product_stock')) {
                self::$length = (int) Valid::inPOST('length_product_stock');
            }

            if (Valid::inPOST('currency_product_stock')) {
                self::$currency = (int) Valid::inPOST('currency_product_stock');
            }

            if (Valid::inPOST('weight_value_product_stock')) {
                self::$weight_value = Valid::inPOST('weight_value_product_stock');
            }

            if (Valid::inPOST('value_length_product_stock')) {
                self::$length_value = Valid::inPOST('value_length_product_stock');
            }

            if (Valid::inPOST('value_width_product_stock')) {
                self::$width_value = Valid::inPOST('value_width_product_stock');
            }

            if (Valid::inPOST('value_height_product_stock')) {
                self::$height_value = Valid::inPOST('value_height_product_stock');
            }

            if (Valid::inPOST('min_quantity_product_stock')) {
                self::$min_quantity = Valid::inPOST('min_quantity_product_stock');
            }

            $selected_attributes = json_encode([]);
            if (Valid::inPOST('selected_attributes')) {
                $selected_attributes = Valid::inPOST('selected_attributes');
            }

            for ($x = 0; $x < Lang::$count; $x++) {

                $this->db
                        ->update(TABLE_PRODUCTS)
                        ->set('name', Valid::inPOST('name_product_stock_' . $x))
                        ->set('last_modified', SystemClock::nowSqlDateTime())
                        ->set('date_available', self::$date_available)
                        ->set('model', Valid::inPOST('model_product_stock'))
                        ->set('price', Valid::inPOST('price_product_stock'))
                        ->set('currency', self::$currency)
                        ->set('quantity', Valid::inPOST('quantity_product_stock'))
                        ->set('unit', self::$unit)
                        ->set('keyword', Valid::inPOST('keyword_product_stock_' . $x))
                        ->set('tags', Valid::inPOST('tags_product_stock_' . $x))
                        ->set('description', Valid::inPOST('description_product_stock_' . $x))
                        ->set('tax', self::$tax)
                        ->set('manufacturer', self::$manufacturers)
                        ->set('vendor_code', self::$vendor_code)
                        ->set('vendor_code_value', Valid::inPOST('vendor_code_value_product_stock'))
                        ->set('weight', self::$weight)
                        ->set('weight_value', self::$weight_value)
                        ->set('dimension', self::$length)
                        ->set('length', self::$length_value)
                        ->set('width', self::$width_value)
                        ->set('height', self::$height_value)
                        ->set('min_quantity', self::$min_quantity)
                        ->set('attributes', $selected_attributes)
                        ->where('id=', Valid::inPOST('edit_product'))
                        ->and('language=', lang('#lang_all')[$x])
                        ->save();
            }

            $Cache = new Cache();
            $Cache->deleteItem('core.new_products');
            $Cache->deleteItem('core.products_' . Valid::inPOST('edit_product'));

            Messages::alert('edit_product', 'success', lang('action_completed_successfully'));
        }
    }

}
