<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

use eMarket\Core\{
    Autorize,
    Pages,
    Pdo
};

/**
 * Orders
 *
 * @package Catalog
 * @author eMarket
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
        $this->autorize();
        $this->data();
        $this->modal();
    }

    /**
     * Autorize
     *
     */
    public function autorize() {
        if (Autorize::$customer == FALSE) {
            header('Location: ?route=login');
            exit;
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$lines = Pdo::getAssoc("SELECT * FROM " . TABLE_ORDERS . " WHERE email=? ORDER BY id DESC", [$_SESSION['email_customer']]);
        Pages::data(self::$lines);
    }

    /**
     * Modal
     *
     */
    public function modal() {
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
