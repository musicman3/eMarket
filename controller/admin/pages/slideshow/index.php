<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$settings = json_encode(\eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW_PREF . "", [])[0]);

// Загручик изображений (ВСТАВЛЯТЬ ПЕРЕД УДАЛЕНИЕМ)
$resize_param = [];
array_push($resize_param, ['125', '94']); // ширина, высота
//array_push($resize_param, ['200','150']);
//array_push($resize_param, ['325','244']);
//array_push($resize_param, ['525','394']);
//array_push($resize_param, ['850','638']);

\eMarket\Files::imgUpload(TABLE_MANUFACTURERS, 'manufacturers', $resize_param);

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
    
    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_SLIDESHOW_PREF . " SET show_interval=?, mouse_stop=?, autostart=?, cicles=?, indicators=?, navigation=? WHERE id=?", [\eMarket\Valid::inPOST('show_interval'), $mouse_stop, $autostart, $cicles, $indicators, $navigation, 1]);
}

// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('view_slideshow')) {
        $view_slideshow = 1;
    } else {
        $view_slideshow = 0;
    }
    
    \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_SLIDESHOW . " SET language=?, url=?, name=?, heading=?, sort=?, status=?", [\eMarket\Valid::inPOST('slide_language'), \eMarket\Valid::inPOST('url'), \eMarket\Valid::inPOST('name'), \eMarket\Valid::inPOST('heading'), 1, $view_slideshow]);
}

// Модальное окно
require_once('modal/index.php');
// Модальное окно
require_once('modal/settings.php');

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>