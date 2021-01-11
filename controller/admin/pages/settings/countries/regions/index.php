<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
// 
if (\eMarket\Valid::inGET('country_id')) {
    $country_id = \eMarket\Valid::inGET('country_id');
}
if (\eMarket\Valid::inPOST('country_id')) {
    $country_id = \eMarket\Valid::inPOST('country_id');
}
if (!isset($country_id)) {
    $country_id = 0;
}

if (\eMarket\Valid::inPOST('add')) {

    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_REGIONS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        \eMarket\Pdo::action("INSERT INTO " . TABLE_REGIONS . " SET id=?, country_id=?, name=?, language=?, region_code=?", [$id, $country_id, \eMarket\Valid::inPOST('name_regions_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('region_code_regions')]);
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('edit')) {

    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        \eMarket\Pdo::action("UPDATE " . TABLE_REGIONS . " SET name=?, region_code=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_regions_' . $x), \eMarket\Valid::inPOST('region_code_regions'), \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('delete')) {

    \eMarket\Pdo::action("DELETE FROM " . TABLE_REGIONS . " WHERE country_id=? AND id=?", [$country_id, \eMarket\Valid::inPOST('delete')]);

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_REGIONS . " WHERE country_id=? ORDER BY name", [$country_id]);
$lines = \eMarket\Func::filterData($sql_data, 'language', lang('#lang_all')[0]);
\eMarket\Pages::table($lines);

require_once('modal/index.php');
