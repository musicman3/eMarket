<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

class Settings {

    /**
     * Название текущего шаблона
     *
     * @return строка
     */
    public function Template() {
        $TEMPLATE = 'default';
        return $TEMPLATE;
    }

    /**
     * Текущая ветка (admin или catalog)
     *
     * @return строка
     */
    public function Path() {
        $VALID = new \eMarket\Core\Valid;
        $PATH = explode('/', ($VALID->inSERVER('REQUEST_URI')))[2];
        return $PATH;
    }

    /**
     * Текущая директория
     *
     * @return строка
     */
    public function TitleDir() {
        $TITLE_DIR = basename(getcwd()); //Текущая директория
        return $TITLE_DIR;
    }


}

?>