<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Modules\Tabs;

use eMarket\Core\{
    Authorize,
    Interfaces,
    Modules,
    Messages,
    Pdo,
    Pages,
    Settings,
    Valid
};
use eMarket\Admin\HeaderMenu;

/**
 * Module Reviews
 *
 * @package Tabs modules
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Reviews {

    public static $reviews = [];
    public static $reviews_count = 0;
    public static $count_to_page = 0;
    public static $author_check = FALSE;
    public static $author = FALSE;
    public static $sql_data = FALSE;
    public static $json_data = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        if (Settings::path() == 'admin') {
            $this->data();
            $this->delete();
            $this->modal();
            $this->publish();
            $this->edit();
        }
        if (Settings::path() == 'catalog') {
            $this->addReview();
            $this->authorCheck();
        }
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_customers][] = ['?route=settings/modules/edit&type=tabs&name=reviews&alias=true', 'bi-chat-left-text', lang('modules_tabs_reviews_name'), '', 'false'];
    }

    /**
     * Install
     *
     * @param array $module (input data)
     */
    public static function install(array $module): void {
        Modules::install($module);
    }

    /**
     * Delete
     *
     * @param array $module (input data)
     */
    public static function uninstall(array $module): void {
        Modules::uninstall($module);
    }

    /**
     * Load data
     *
     * @return array $interface (data)
     */
    public static function load(): void {

        $INTERFACE = new Interfaces();
        self::reviewsData();
        self::reviewsCount();

        $interface = [
            'chanel_module_name' => 'reviews',
            'chanel_name' => lang('modules_tabs_reviews_name') . ' <span id="reviews_count" class="badge bg-primary">' . Reviews::$reviews_count . '</span>'
        ];

        $INTERFACE->save('tabs', 'reviews', $interface);
    }

    /**
     * Status
     *
     * @return mixed
     */
    public static function status(): mixed {
        $module_active = Pdo::getValue("SELECT active FROM " . TABLE_MODULES . " WHERE name=? AND type=?", ['reviews', 'tabs']);
        return $module_active;
    }

    /**
     * Data
     *
     */
    public function data(): void {
        $MODULE_DB = Modules::moduleDatabase();

        self::$sql_data = Pdo::getAssoc("SELECT *, UNIX_TIMESTAMP (date_add) FROM " . $MODULE_DB . " WHERE status=? ORDER BY id DESC", [0]);
        Pages::data(self::$sql_data);
    }

    /**
     * Author check
     *
     */
    public function authorCheck(): void {
        if (Authorize::$customer != FALSE) {
            self::$author_check = Pdo::getValue("SELECT id FROM " . DB_PREFIX . "modules_tabs_reviews WHERE author=? AND product_id=?", [Authorize::$customer['email'], Valid::inGET('id')]);
        }
    }

    /**
     * Review author
     *
     * @param string $email Email
     * @return mixed Author data
     */
    public static function reviewAuthor(string $email): mixed {
        self::$author = Pdo::getAssoc("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$email])[0];

        return self::$author;
    }

    /**
     * Purchase check
     *
     * @param string $email Email
     * @return array Author data
     */
    public static function purchaseCheck(string $email): string {
        $purchase = Pdo::getAssoc("SELECT products_order FROM " . TABLE_ORDERS . " WHERE email=?", [$email]);
        $purchase_flag = 'FALSE';

        foreach ($purchase as $data) {
            foreach ($data as $product) {
                $json_product = json_decode($product, true);
                foreach ($json_product as $json) {
                    if ($json['id'] == Valid::inGET('id')) {
                        $purchase_flag = 'TRUE';
                    }
                }
            }
        }

        return $purchase_flag;
    }

    /**
     * Review author
     *
     * @return float Author data
     */
    public static function averageRating(): float {
        $rating = 0;
        $count = 0;
        foreach (self::$reviews as $review) {
            $rating = (int) $rating + (int) $review['stars'];
            $count++;
        }
        $average_rating = round($rating / $count * 2) / 2;
        return $average_rating;
    }

    /**
     * Add review
     *
     */
    public function addReview(): void {
        if (Authorize::$customer != FALSE && Valid::inPostJson('review')) {
            Pdo::action("INSERT INTO " . DB_PREFIX . "modules_tabs_reviews SET product_id=?, author=?, stars=?, status=?, likes=?, date_add=?, date_edit=?, reviews=?", [
                Valid::inGET('id'), Authorize::$customer['email'], Valid::inPostJson('stars'), 0, 0, date('Y-m-d H:i:s'), NULL, json_encode([Valid::inPostJson('review')])
            ]);
        }
    }

    /**
     * Review data
     *
     */
    public static function reviewsData(): void {
        if (!Valid::inPostJson('start_review')) {
            self::$reviews = Pdo::getAssoc("SELECT * FROM " . DB_PREFIX . "modules_tabs_reviews WHERE product_id=? AND status=? ORDER BY date_add DESC LIMIT 0," . Settings::linesOnPage(), [Valid::inGET('id'), 1]);
        } else {
            self::$reviews = Pdo::getAssoc("SELECT * FROM " . DB_PREFIX . "modules_tabs_reviews WHERE product_id=? AND status=? ORDER BY date_add DESC LIMIT " . Valid::inPostJson('start_review') . "," . Settings::linesOnPage(), [Valid::inGET('id'), 1]);
        }
        self::$count_to_page = count(self::$reviews);
    }

    /**
     * Review status
     * 
     * @return mixed Author review status
     *
     */
    public static function reviewStatus(): mixed {
        $data_review = Pdo::getValue("SELECT status FROM " . DB_PREFIX . "modules_tabs_reviews WHERE product_id=? AND author=?", [Valid::inGET('id'), Authorize::$customer['email']]);

        return $data_review;
    }

    /**
     * Reviews count
     *
     */
    public static function reviewsCount(): void {
        $count = Pdo::getRowCount("SELECT * FROM " . DB_PREFIX . "modules_tabs_reviews WHERE product_id=? AND status=?", [Valid::inGET('id'), 1]);
        self::$reviews_count = $count;
    }

    /**
     * Publish
     *
     */
    public function publish(): void {
        if (Valid::inPOST('publish')) {

            $MODULE_DB = Modules::moduleDatabase();

            $data = Pdo::getValue("SELECT * FROM " . $MODULE_DB, []);
            if ($data != FALSE) {
                Pdo::action("UPDATE " . $MODULE_DB . " SET status=? WHERE id=?", [1, Valid::inPOST('publish')]);

                Messages::alert('publish_tabs_reviews', 'success', lang('action_completed_successfully'));
                exit;
            }
        }
    }

    /**
     * Edit
     *
     */
    public function edit(): void {
        if (Valid::inPOST('edit')) {

            $MODULE_DB = Modules::moduleDatabase();

            Pdo::action("UPDATE " . $MODULE_DB . " SET reviews=?, date_edit=? WHERE id=?", [
                json_encode([Valid::inPOST('review')]), date('Y-m-d H:i:s'), Valid::inPOST('edit')]);

            Messages::alert('edit_tabs_reviews', 'success', lang('action_completed_successfully'));
            exit;
        }
    }

    /**
     * Delete
     *
     */
    public function delete(): void {
        if (Valid::inPOST('delete')) {

            $MODULE_DB = Modules::moduleDatabase();

            Pdo::action("DELETE FROM " . $MODULE_DB . " WHERE id=?", [Valid::inPOST('delete')]);
            Messages::alert('delete_tabs_reviews', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Modal
     *
     */
    public function modal(): void {
        self::$json_data = json_encode([]);
        $reviews = [];
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $reviews[$modal_id] = $sql_modal['reviews'];
                    }
                }

                self::$json_data = json_encode([
                    'reviews' => $reviews,
                ]);
            }
        }
    }

}
