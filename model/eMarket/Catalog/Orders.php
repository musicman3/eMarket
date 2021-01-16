<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

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
        if (\eMarket\Autorize::$CUSTOMER == FALSE) {
            header('Location: ?route=login');
            exit;
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$lines = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDERS . " WHERE email=? ORDER BY id DESC", [$_SESSION['email_customer']]);
        \eMarket\Pages::table(self::$lines);
    }

    /**
     * Modal
     *
     */
    public function modal() {
        self::$orders_edit = json_encode([]);
        for ($i = \eMarket\Pages::$start; $i < \eMarket\Pages::$finish; $i++) {
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
