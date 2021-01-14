<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Data Interfaces
 *
 * @package Interfaces
 * @author eMarket
 * 
 */
class Interfaces {

    public static $STORAGE = [];

    /**
     * Add
     *
     */
    public function add($block, $name, $data) {
        if (!array_key_exists($block, self::$STORAGE)) {
            self::$STORAGE[$block] = [];
        }
        self::$STORAGE[$block][$name] = $data;
    }

    /**
     * Delete
     *
     */
    public function delete($block) {
        if (array_key_exists($block, self::$STORAGE)) {
            unset(self::$STORAGE[$block]);
        }
    }

    /**
     * Empty
     *
     */
    public function empty() {
        self::$STORAGE = [];
    }

}