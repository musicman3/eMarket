<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Index
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Index {

    /**
     * Route
     *
     * @return string|FALSE url
     */
    public function route() {
        
        $str = ROOT . '/view/' . \eMarket\Settings::template() . '/admin/constructor.php';
        if (file_exists($str)) {
            return $str;
        } else {
            return false;
        }
    }

}
