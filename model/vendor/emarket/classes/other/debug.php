<?php

// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

namespace eMarket\Classes\Other;

class Debug {

    /**
     * Удобное отображение массива при отладке
     *
     * @param массив $var
     * @return null
     */
    public function var_dump($var) {
        static $int = 0;
        echo '<pre><b>' . $int . '</b> ';
        print_r($var);
        echo '</pre>';
        $int++;
    }

}

?>