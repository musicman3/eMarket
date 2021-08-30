<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Data Interfaces
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Interfaces {

    public static $storage = [];

    /**
     * Save
     *
     */
    public function save($block, $name, $data) {
        self::$storage[$block][$name] = $data;
    }

    /**
     * Load
     *
     * @return array Storage block
     */
    public function load($block, $name = null, $data = null) {
        if ($name != null && $data != null && array_key_exists($block, self::$storage) && array_key_exists($name, self::$storage[$block]) && array_key_exists($data, self::$storage[$block][$name])) {
            return self::$storage[$block][$name][$data];
        }
        if ($name != null && array_key_exists($block, self::$storage) && array_key_exists($name, self::$storage[$block])) {
            return self::$storage[$block][$name];
        }
        if ($name == null && array_key_exists($block, self::$storage)) {
            return self::$storage[$block];
        }
    }

    /**
     * Delete
     *
     */
    public function delete($block) {
        if (array_key_exists($block, self::$storage)) {
            unset(self::$storage[$block]);
        }
    }

    /**
     * Empty
     *
     */
    public function empty() {
        self::$storage = [];
    }

}
