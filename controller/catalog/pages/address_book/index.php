<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inPOST('countries_select')) {
    $regions_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_REGIONS . " WHERE language=? AND country_id=? ORDER BY name ASC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('countries_select')]);
    echo json_encode($regions_data);
    exit;
}

if ($CUSTOMER == FALSE) {
    header('Location: ?route=login'); // переадресация на LOGIN
}

$countries_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY name ASC", [lang('#lang_all')[0]]);
$regions_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_REGIONS . " WHERE language=? AND country_id=? ORDER BY name ASC", [lang('#lang_all')[0], $countries_data[0]['id']]);

$country_name = [];
foreach ($countries_data as $val){
    $country_name[$val['id']] = [$val['alpha_2'], $val['name']];

}

$adress_array_data_temp = \eMarket\Pdo::getCellFalse("SELECT address_book FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']]);

// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {
// Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default')) {
        $default = 1;
    } else {
        $default = 0;
    }

    if ($adress_array_data_temp == FALSE) {
        $adress_array_data = [];
    } else {
        $adress_array_data = json_decode($adress_array_data_temp, 1);
    }

    $adress_array = ['countries_id' => \eMarket\Valid::inPOST('countries'),
        'regions_id' => \eMarket\Valid::inPOST('regions'),
        'city' => \eMarket\Valid::inPOST('city'),
        'zip' => \eMarket\Valid::inPOST('zip'),
        'address' => \eMarket\Valid::inPOST('address'),
        'default' => $default];

    array_push($adress_array_data, $adress_array);

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET address_book=? WHERE email=?", [json_encode($adress_array_data), $_SESSION['email_customer']]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

//\eMarket\Debug::trace($country_name);
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>