<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// JSON ECHO
if (\eMarket\Valid::inPOST('countries_select')) {
    $regions_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_REGIONS . " WHERE language=? AND country_id=? ORDER BY name ASC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('countries_select')]);
    echo json_encode($regions_data);
    exit;
}

if ($CUSTOMER == FALSE) {
    header('Location: ?route=login'); // переадресация на LOGIN
}

$countries_array = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY name ASC", [lang('#lang_all')[0]]);
$regions_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_REGIONS . " WHERE language=? AND country_id=? ORDER BY name ASC", [lang('#lang_all')[0], $countries_array[0]['id']]);

foreach ($countries_array as $val) {
    $countries_data[$val['id']] = [$val['alpha_2'], $val['name']];
}

$address_data_json = \eMarket\Pdo::getCellFalse("SELECT address_book FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']]);

// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {
// Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default')) {
        $default = 1;
    } else {
        $default = 0;
    }

    if ($address_data_json == FALSE) {
        $address_data = [];
    } else {
        $address_data = json_decode($address_data_json, 1);
    }

    $address_array = ['countries_id' => \eMarket\Valid::inPOST('countries'),
        'regions_id' => \eMarket\Valid::inPOST('regions'),
        'city' => \eMarket\Valid::inPOST('city'),
        'zip' => \eMarket\Valid::inPOST('zip'),
        'address' => \eMarket\Valid::inPOST('address'),
        'default' => $default];

    foreach ($address_data as $data) {
        $x = 0;
        if ($data['default'] == 1 && $default == 1) {
            $address_data[$x]['default'] = 0;
        }
        $x++;
    }
    array_unshift($address_data, $address_array);

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET address_book=? WHERE email=?", [json_encode($address_data), $_SESSION['email_customer']]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {

    if ($address_data_json == FALSE) {
        $address_data = [];
    } else {
        $address_data = json_decode($address_data_json, 1);
    }
    $number = (int) \eMarket\Valid::inPOST('delete') - 1;
    if ($address_data[$number]['default'] == 1 && count($address_data) > 1) {
        unset($address_data[$number]);
        $address_data_out = array_values($address_data);
        $address_data_out[0]['default'] = 1;
    } else {
        unset($address_data[$number]);
        $address_data_out = array_values($address_data);
    }

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET address_book=? WHERE email=?", [json_encode($address_data_out), $_SESSION['email_customer']]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}
//$jsondata = \eMarket\Pdo::getCellFalse("SELECT JSON_EXTRACT(address_book, '$[*].zip', '$[0].address') FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']]);
//\eMarket\Debug::trace(json_decode($address_data_json, 1));
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>