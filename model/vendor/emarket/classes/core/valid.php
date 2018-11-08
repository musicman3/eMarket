<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

namespace eMarket\Classes\Core;

class Valid {

    // Валидация глобальных переменных $_POST[]
    function inPOST($name) {
        if (filter_input(INPUT_POST, $name, FILTER_DEFAULT) == TRUE) {
            return (isset($_POST[$name])) ? $_POST[$name] : null;
        }
    }
    
        // Валидация глобальных переменных $_POST[] с массивом
    function inPostArray($name) {
        if (filter_input(INPUT_POST, $name, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) == TRUE) {
            return (isset($_POST[$name])) ? $_POST[$name] : null;
        }
    }

    // Валидация глобальных переменных $_GET[]
    function inGET($name) {
        if (filter_input(INPUT_GET, $name, FILTER_DEFAULT) == TRUE) {
            return (isset($_GET[$name])) ? $_GET[$name] : null;
        }
    }
    
        // Валидация глобальных переменных $_GET[] с массивом
    function inGetArray($name) {
        if (filter_input(INPUT_GET, $name, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) == TRUE) {
            return (isset($_GET[$name])) ? $_GET[$name] : null;
        }
    }

    // Валидация глобальных переменных $_SERVER[]
    function inSERVER($name) {
        if (filter_input(INPUT_SERVER, $name) == TRUE) {
            return (isset($_SERVER[$name])) ? $_SERVER[$name] : null;
        }
    }

    // Валидация глобальных переменных $_COOKIE[]
    function inCOOKIE($name) {
        if (filter_input(INPUT_COOKIE, $name) == TRUE) {
            return (isset($_COOKIE[$name])) ? $_COOKIE[$name] : null;
        }
    }

}

?>
