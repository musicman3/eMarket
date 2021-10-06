<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

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
     * @param string $block Block
     * @param string $name Name
     * @param mixed $data Data
     */
    public function save(string $block, string $name, mixed $data): void {
        self::$storage[$block][$name] = $data;
    }

    /**
     * Load
     *
     * @param string $block Block
     * @param string $name Name
     * @param mixed $data Data
     * @return mixed Storage block
     */
    public function load(string $block, ?string $name = null, mixed $data = null): mixed {
        if ($name != null && $data != null && array_key_exists($block, self::$storage) && array_key_exists($name, self::$storage[$block]) && array_key_exists($data, self::$storage[$block][$name])) {
            return self::$storage[$block][$name][$data];
        }
        if ($name != null && array_key_exists($block, self::$storage) && array_key_exists($name, self::$storage[$block])) {
            return self::$storage[$block][$name];
        }
        if ($name == null && array_key_exists($block, self::$storage)) {
            return self::$storage[$block];
        }
        return false;
    }

    /**
     * Delete
     *
     * @param string $block Block
     */
    public function delete(string $block): void {
        if (array_key_exists($block, self::$storage)) {
            unset(self::$storage[$block]);
        }
    }

    /**
     * Empty
     *
     */
    public function empty(): void {
        self::$storage = [];
    }

}
