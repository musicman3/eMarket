<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Формируем данные по адресам
$address_data_json = \eMarket\Pdo::getCellFalse("SELECT address_book FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']]);

if ($address_data_json == FALSE) {
    $address_data = [];
} else {
    $address_data = json_decode($address_data_json, 1);
}

$x = 0;
foreach ($address_data as $address_val) {
    $countries_array = \eMarket\Pdo::getColAssoc("SELECT id, name FROM " . TABLE_COUNTRIES . " WHERE language=? AND id=? ORDER BY name ASC", [lang('#lang_all')[0], $address_val['countries_id']])[0];
    $regions_array = \eMarket\Pdo::getColAssoc("SELECT id, name FROM " . TABLE_REGIONS . " WHERE language=? AND id=? ORDER BY name ASC", [lang('#lang_all')[0], $address_val['regions_id']])[0];
    if ($address_val['countries_id'] == $countries_array['id']) {
        $address_data[$x]['countries_name'] = $countries_array['name'];
        $address_data[$x]['regions_name'] = $regions_array['name'];
    }
    $x++;
}
?>
