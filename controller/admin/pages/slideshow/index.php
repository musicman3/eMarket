<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// Модальное окно
require_once('modal/index.php');
// Модальное окно
require_once('modal/settings.php');

$settings = json_encode(\eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW_PREF . "", [])[0]);

if (\eMarket\Valid::inPOST('slideshow_pref')) {

    if (\eMarket\Valid::inPOST('mouse_stop')) {
        $mouse_stop = 1;
    } else {
        $mouse_stop = 0;
    }
    if (\eMarket\Valid::inPOST('autostart')) {
        $autostart = 1;
    } else {
        $autostart = 0;
    }
    if (\eMarket\Valid::inPOST('cicles')) {
        $cicles = 1;
    } else {
        $cicles = 0;
    }
    if (\eMarket\Valid::inPOST('indicators')) {
        $indicators = 1;
    } else {
        $indicators = 0;
    }
    if (\eMarket\Valid::inPOST('navigation')) {
        $navigation = 1;
    } else {
        $navigation = 0;
    }
    
    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_SLIDESHOW_PREF . " SET show_interval=?, mouse_stop=?, autostart=?, cicles=?, indicators=?, navigation=?", [\eMarket\Valid::inPOST('show_interval'), $mouse_stop, $autostart, $cicles, $indicators, $navigation]);
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>