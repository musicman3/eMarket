<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании
$json_data = json_encode([]);
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i]['id']) == TRUE) {

        $modal_id = $lines[$i]['id']; // ID

        foreach ($sql_data as $sql_modal) {
            //Языковые
            if ($sql_modal['id'] == $modal_id) {
                $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
            }
            if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                $site[$modal_id] = $sql_modal['site'];
                $logo[$modal_id] = json_decode($sql_modal['logo'], 1);
                $logo_general[$modal_id] = $sql_modal['logo_general'];
            }
        }
        //Сортируем языковые
        ksort($name);

        $json_data = json_encode([
            'name' => $name,
            'site' => $site,
            'logo' => $logo,
            'logo_general' => $logo_general
        ]);
    }
}
?>
