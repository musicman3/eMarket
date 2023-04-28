<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Authorize,
    Pages,
};
use Cruder\Db;

/**
 * Orders
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Orders {

    public static $routing_parameter = 'orders';
    public $title = 'title_orders_index';
    public static $lines;
    public static $orders_edit = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->authorize();
        $this->data();
        $this->modal();
    }

    /**
     * Authorize
     *
     */
    private function authorize(): void {
        if (Authorize::$customer == FALSE) {
            header('Location: ?route=login');
            exit;
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {

        self::$lines = Db::connect()
                ->read(TABLE_ORDERS)
                ->selectAssoc('*')
                ->where('email=', $_SESSION['customer_email'])
                ->orderByDesc('id')
                ->save();

        Pages::data(self::$lines);
    }

    /**
     * Modal
     *
     */
    private function modal(): void {
        self::$orders_edit = json_encode([]);
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(self::$lines[$i]['id']) == TRUE) {

                $modal_id = self::$lines[$i]['id'];

                foreach (self::$lines as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $orders[$modal_id] = $sql_modal;
                    }
                }

                self::$orders_edit = json_encode($orders);
            }
        }
    }

}
