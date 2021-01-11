<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$_SESSION['country_page'] = \eMarket\Valid::inSERVER('REQUEST_URI');

if (\eMarket\Valid::inPOST('add')) {

    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        \eMarket\Pdo::action("INSERT INTO " . TABLE_COUNTRIES . " SET id=?, name=?, language=?, alpha_2=?, alpha_3=?, address_format=?", [$id, \eMarket\Valid::inPOST('name_countries_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('alpha_2_countries'), \eMarket\Valid::inPOST('alpha_3_countries'), \eMarket\Valid::inPOST('address_format_countries')]);
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('edit')) {

    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        \eMarket\Pdo::action("UPDATE " . TABLE_COUNTRIES . " SET name=?, alpha_2=?, alpha_3=?, address_format=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_countries_' . $x), \eMarket\Valid::inPOST('alpha_2_countries'), \eMarket\Valid::inPOST('alpha_3_countries'), \eMarket\Valid::inPOST('address_format_countries'), \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('delete')) {

    \eMarket\Pdo::action("DELETE FROM " . TABLE_COUNTRIES . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    \eMarket\Pdo::action("DELETE FROM " . TABLE_REGIONS . " WHERE country_id=?", [\eMarket\Valid::inPOST('delete')]);

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_COUNTRIES . " ORDER BY name", []);
$lines = \eMarket\Func::filterData($sql_data, 'language', lang('#lang_all')[0]);
\eMarket\Pages::table($lines);

require_once('modal/index.php');
