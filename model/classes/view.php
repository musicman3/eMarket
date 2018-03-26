<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

namespace Model\Classes\View;

class ViewClass {

    function Routing() {

        $template = 'default';

        $str = str_replace('controller', 'view/' . $template, $_SERVER['SCRIPT_FILENAME']);

        return $str;
    }

}

?>