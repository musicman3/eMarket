<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
//
//ЗАГРУЖАЕМ БАЗОВЫЕ ПЕРЕМЕННЫЕ
$TEMPLATE = 'default'; //Название текущего шаблона
$PATH = explode('/', ($VALID->inSERVER('REQUEST_URI')))[2]; //Текущая ветка (admin или catalog)
$TITLE_DIR = basename(getcwd()); //Текущая директория
?>