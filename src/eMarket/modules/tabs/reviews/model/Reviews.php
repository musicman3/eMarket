<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Modules\Tabs;

use eMarket\Core\{
    Authorize,
    Clock\SystemClock,
    DataBuffer,
    Interfaces\TabsModulesInterface,
    Modules,
    Messages,
    Pages,
    Settings,
    Valid
};
use eMarket\Admin\HeaderMenu;
use Cruder\Db;

/**
 * Module Reviews
 *
 * @package Tabs modules
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Reviews implements TabsModulesInterface {

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
        HeaderMenu::$menu[HeaderMenu::$menu_marketing][] = ['?route=modules/edit&type=tabs&name=reviews&alias=true', 'bi-chat-left-text', lang('modules_tabs_reviews_name'), '', 'false'];
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

        $DataBuffer = new DataBuffer();
        self::reviewsData();
        self::reviewsCount();

        $interface = [
            'chanel_module_name' => 'reviews',
            'chanel_name' => lang('modules_tabs_reviews_name') . ' <span id="reviews_count" class="badge bg-primary">' . Reviews::$reviews_count . '</span>'
        ];

        $DataBuffer->save('tabs', 'reviews', $interface);
    }

    /**
     * Status
     *
     * @return mixed
     */
    public static function status(): mixed {

        $module_active = Db::connect()
                ->read(TABLE_MODULES)
                ->selectValue('active')
                ->where('name=', 'reviews')
                ->and('type=', 'tabs')
                ->orderByDesc('id')
                ->save();

        return $module_active;
    }

    /**
     * Data
     *
     */
    public function data(): void {
        $MODULE_DB = Modules::moduleDatabase();

        self::$sql_data = Db::connect()
                ->read($MODULE_DB)
                ->selectAssoc('*, {{UNIX_TIMESTAMP->date_add}}')
                ->where('status=', 0)
                ->orderByDesc('id')
                ->save();

        Pages::data(self::$sql_data);
    }

    /**
     * Author check
     *
     */
    public function authorCheck(): void {
        if (Authorize::$customer != FALSE) {

            self::$author_check = Db::connect()
                    ->read(DB_PREFIX . 'modules_tabs_reviews')
                    ->selectValue('id')
                    ->where('author=', Authorize::$customer['email'])
                    ->and('product_id=', Valid::inGET('id'))
                    ->save();
        }
    }

    /**
     * Review author
     *
     * @param string $email Email
     * @return mixed Author data
     */
    public static function reviewAuthor(string $email): mixed {

        self::$author = Db::connect()
                        ->read(TABLE_CUSTOMERS)
                        ->selectAssoc('*')
                        ->where('email=', $email)
                        ->save()[0];

        return self::$author;
    }

    /**
     * Purchase check
     *
     * @param string $email Email
     * @return array Author data
     */
    public static function purchaseCheck(string $email): string {

        $purchase = Db::connect()
                ->read(TABLE_ORDERS)
                ->selectAssoc('products_order')
                ->where('email=', $email)
                ->save();

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

            Db::connect()
                    ->create(DB_PREFIX . 'modules_tabs_reviews')
                    ->set('product_id', Valid::inGET('id'))
                    ->set('author', Authorize::$customer['email'])
                    ->set('stars', Valid::inPostJson('stars'))
                    ->set('status', 0)
                    ->set('likes', 0)
                    ->set('date_add', SystemClock::nowSqlDateTime())
                    ->set('date_edit', NULL)
                    ->set('reviews', json_encode([Valid::inPostJson('review')]))
                    ->save();
        }
    }

    /**
     * Review data
     *
     */
    public static function reviewsData(): void {
        if (!Valid::inPostJson('start_review')) {

            self::$reviews = Db::connect()
                    ->read(DB_PREFIX . 'modules_tabs_reviews')
                    ->selectAssoc('*')
                    ->where('product_id=', Valid::inGET('id'))
                    ->and('status=', 1)
                    ->orderByDesc('date_add')
                    ->limit(Settings::linesOnPage())
                    ->save();
        } else {

            self::$reviews = Db::connect()
                    ->read(DB_PREFIX . 'modules_tabs_reviews')
                    ->selectAssoc('*')
                    ->where('product_id=', Valid::inGET('id'))
                    ->and('status=', 1)
                    ->orderByDesc('date_add')
                    ->limit(Settings::linesOnPage(), Valid::inPostJson('start_review'))
                    ->save();
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

        $data_review = Db::connect()
                ->read(DB_PREFIX . 'modules_tabs_reviews')
                ->selectValue('status')
                ->where('product_id=', Valid::inGET('id'))
                ->and('author=', Authorize::$customer['email'])
                ->save();

        return $data_review;
    }

    /**
     * Reviews count
     *
     */
    public static function reviewsCount(): void {

        $count = Db::connect()
                ->read(DB_PREFIX . 'modules_tabs_reviews')
                ->selectRowCount('*')
                ->where('product_id=', Valid::inGET('id'))
                ->and('status=', 1)
                ->save();

        self::$reviews_count = $count;
    }

    /**
     * Publish
     *
     */
    public function publish(): void {
        if (Valid::inPOST('publish')) {

            $MODULE_DB = Modules::moduleDatabase();

            $data = Db::connect()
                    ->read($MODULE_DB)
                    ->selectValue('*')
                    ->save();

            if ($data != FALSE) {

                Db::connect()
                        ->update($MODULE_DB)
                        ->set('status', 1)
                        ->where('id=', Valid::inPOST('publish'))
                        ->save();

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

            Db::connect()
                    ->update($MODULE_DB)
                    ->set('reviews', json_encode([Valid::inPOST('review')]))
                    ->set('date_edit', SystemClock::nowSqlDateTime())
                    ->where('id=', Valid::inPOST('edit'))
                    ->save();

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

            Db::connect()
                    ->delete($MODULE_DB)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

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
