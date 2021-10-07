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
    Pdo
};

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
    public function authorize(): void {
        if (Authorize::$customer == FALSE) {
            header('Location: ?route=login');
            exit;
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        self::$lines = Pdo::getAssoc("SELECT * FROM " . TABLE_ORDERS . " WHERE email=? ORDER BY id DESC", [$_SESSION['email_customer']]);
        Pages::data(self::$lines);
    }

    /**
     * Modal
     *
     */
    public function modal(): void {
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
