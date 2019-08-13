<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Класс для работы с модулями
 *
 * @package Modules
 * @author eMarket
 * 
 */
class Modules {

    /**
     * Инициализация модулей
     *
     * @return bool (TRUE/FALSE)
     */
    public function init() {

        $DEBUG = new \eMarket\Other\Debug;
        $TREE = new \eMarket\Core\Tree;

        $path = getenv('DOCUMENT_ROOT') . '/modules/';
        $modules_name = $TREE->allDirForPath($path);


        $DEBUG->trace($modules_name);
    }

}

?>