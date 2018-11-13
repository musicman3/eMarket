<?php

// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

namespace eMarket\Classes\Core;

class View {

    /**
     * Роутинг данных из View
     *
     * @return строка $str
     */
    public function Routing() {

        global $TEMPLATE;

        $str = str_replace('controller', 'view/' . $TEMPLATE, getenv('SCRIPT_FILENAME'));

        return $str;
    }

}

?>