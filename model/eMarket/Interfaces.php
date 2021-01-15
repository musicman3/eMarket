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
     * Save
     *
     */
    public function save($block, $name, $data) {
        self::$STORAGE[$block][$name] = $data;
    }

    /**
     * Load
     *
     * @return array Storage block
     */
    public function load($block, $name = null, $data = null) {
        if ($name != null && $data != null && array_key_exists($block, self::$STORAGE) && array_key_exists($name, self::$STORAGE[$block]) && array_key_exists($data, self::$STORAGE[$block][$name])) {
            return self::$STORAGE[$block][$name][$data];
        }
        if ($name != null && array_key_exists($block, self::$STORAGE) && array_key_exists($name, self::$STORAGE[$block])) {
            return self::$STORAGE[$block][$name];
        }
        if ($name == null && array_key_exists($block, self::$STORAGE)) {
            return self::$STORAGE[$block];
        }
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
