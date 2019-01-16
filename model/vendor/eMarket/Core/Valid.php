<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Класс для валидации данных
 *
 * @package Valid
 * @author eMarket
 * 
 */
class Valid {

    /**
     * Валидация глобальных переменных $_POST[]
     *
     * @param массив $name (массив или строка $name)
     * @return массив $name (массив или строка $name)
     */
    public function inPOST($name) {
        if (filter_input(INPUT_POST, $name, FILTER_DEFAULT, FILTER_FORCE_ARRAY) == TRUE) {
            return (isset($_POST[$name])) ? $_POST[$name] : null;
        }
    }

    /**
     * Валидация глобальных переменных $_GET[]
     *
     * @param массив $name (массив или строка $name)
     * @return массив $name (массив или строка $name)
     */
    public function inGET($name) {
        if (filter_input(INPUT_GET, $name, FILTER_DEFAULT, FILTER_FORCE_ARRAY) == TRUE) {
            return (isset($_GET[$name])) ? $_GET[$name] : null;
        }
    }

    /**
     * Валидация глобальных переменных $_SERVER[]
     *
     * @param строка $name (строка $name)
     * @return строка $name (строка $name)
     */
    public function inSERVER($name) {
        if (filter_input(INPUT_SERVER, $name, FILTER_DEFAULT, FILTER_FORCE_ARRAY) == TRUE) {
            return (isset($_SERVER[$name])) ? $_SERVER[$name] : null;
        }
    }

    /**
     * Валидация глобальных переменных $_COOKIE[]
     *
     * @param строка $name (строка $name)
     * @return строка $name (строка $name)
     */
    public function inCOOKIE($name) {
        if (filter_input(INPUT_COOKIE, $name) == TRUE) {
            return (isset($_COOKIE[$name])) ? $_COOKIE[$name] : null;
        }
    }

}

?>
