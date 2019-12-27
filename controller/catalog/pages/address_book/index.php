<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if ($CUSTOMER == FALSE) {
    header('Location: ?route=login'); // переадресация на LOGIN
}
// JSON ECHO
if (\eMarket\Valid::inPOST('countries_select')) {
    $regions_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_REGIONS . " WHERE language=? AND country_id=? ORDER BY name ASC", [lang('#lang_all')[0], \eMarket\Valid::inPOST('countries_select')]);
    echo str_replace("'", "&#8216;", json_encode($regions_data));
    exit;
}

$countries_array = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY name ASC", [lang('#lang_all')[0]]);
$countries_data_json = str_replace("'", "&#8216;", json_encode($countries_array));

foreach ($countries_array as $val) {
    $countries_data[$val['id']] = [$val['alpha_2'], $val['name']];
}

$address_data_json = \eMarket\Pdo::getCellFalse("SELECT address_book FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']]);

if ($address_data_json == FALSE) {
    $address_data = [];
} else {
    $address_data = json_decode($address_data_json, 1);
}

$x = 0;
foreach ($address_data as $address_val) {
    $countries_array = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_COUNTRIES . " WHERE language=? AND id=? ORDER BY name ASC", [lang('#lang_all')[0], $address_val['countries_id']])[0];
    $regions_array = \eMarket\Pdo::getColAssoc("SELECT id, name FROM " . TABLE_REGIONS . " WHERE language=? AND id=? ORDER BY name ASC", [lang('#lang_all')[0], $address_val['regions_id']])[0];
    if ($address_val['countries_id'] == $countries_array['id']) {
        $address_data[$x]['countries_name'] = $countries_array['name'];
        $address_data[$x]['alpha_2'] = $countries_array['alpha_2'];
        $address_data[$x]['regions_name'] = $regions_array['name'];
    }
    $x++;
}

// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {
// Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default')) {
        $default = 1;
    } else {
        $default = 0;
    }

    $address_array = ['countries_id' => \eMarket\Valid::inPOST('countries'),
        'regions_id' => \eMarket\Valid::inPOST('regions'),
        'city' => \eMarket\Valid::inPOST('city'),
        'zip' => \eMarket\Valid::inPOST('zip'),
        'address' => \eMarket\Valid::inPOST('address'),
        'default' => $default];

    $x = 0;
    foreach ($address_data as $data) {
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

// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('edit')) {
// Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default_edit')) {
        $default = 1;
    } else {
        $default = 0;
    }

    $address_array = ['countries_id' => \eMarket\Valid::inPOST('countries_edit'),
        'regions_id' => \eMarket\Valid::inPOST('regions_edit'),
        'city' => \eMarket\Valid::inPOST('city_edit'),
        'zip' => \eMarket\Valid::inPOST('zip_edit'),
        'address' => \eMarket\Valid::inPOST('address_edit'),
        'default' => $default];

    $x = 0;
    foreach ($address_data as $data) {
        if ($data['default'] == 1 && $default == 1) {
            $address_data[$x]['default'] = 0;
        }
        $x++;
    }

    $address_data[(int) \eMarket\Valid::inPOST('edit') - 1] = $address_array;

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET address_book=? WHERE email=?", [json_encode($address_data), $_SESSION['email_customer']]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {

    $number = (int) \eMarket\Valid::inPOST('delete') - 1;
    if ($address_data[$number]['default'] == 1 && count($address_data) > 1) {
        unset($address_data[$number]);
        $address_data_out = array_values($address_data);
        $address_data_out[0]['default'] = 1;
    } else {
        unset($address_data[$number]);
        $address_data_out = array_values($address_data);
    }
    
    if (count($address_data_out) == 0){
        $address_data_out_table = NULL;
    }else{
        $address_data_out_table = json_encode($address_data_out);
    }

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET address_book=? WHERE email=?", [$address_data_out_table, $_SESSION['email_customer']]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}
//$jsondata = \eMarket\Pdo::getCellFalse("SELECT JSON_EXTRACT(address_book, '$[*].zip', '$[0].address') FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']]);
//\eMarket\Debug::trace($countries_array_id);
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>