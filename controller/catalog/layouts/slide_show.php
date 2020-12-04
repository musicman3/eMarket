<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$slideshow = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$slideshow_pref = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW_PREF . " WHERE id=?", [1])[0];

$slide_interval = $slideshow_pref['show_interval'];

if ($slideshow_pref['mouse_stop'] == 1) {
    $slide_pause = 'hover';
} else {
    $slide_pause = 'false';
}

if ($slideshow_pref['autostart'] == 1) {
    $autostart = 'carousel';
} else {
    $autostart = 'false';
}

if ($slideshow_pref['cicles'] == 1) {
    $cicles = 'true';
} else {
    $cicles = 'false';
}

if ($slideshow_pref['indicators'] == 1) {
    $indicators = 'true';
} else {
    $indicators = 'false';
}

if ($slideshow_pref['navigation'] == 1) {
    $navigation_key = 'true';
} else {
    $navigation_key = 'false';
}

$this_time = time();

$slideshow_array = [];
foreach ($slideshow as $images_data) {
    foreach (json_decode($images_data['logo'], 1) as $logo) {
        if ($images_data['status'] == '1' && strtotime($images_data['date_start']) < $this_time && strtotime($images_data['date_finish']) > $this_time) {
            array_push($slideshow_array, $logo);
        }
    }
}
$active_class = ' active';
//\eMarket\Debug::trace($slideshow_array);
?>