<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

namespace emarket\classes\core;

class view {

    function Routing() {

        global $TEMPLATE;

        $str = str_replace('controller', 'view/' . $TEMPLATE, $_SERVER['SCRIPT_FILENAME']);

        return $str;
    }

}

?>