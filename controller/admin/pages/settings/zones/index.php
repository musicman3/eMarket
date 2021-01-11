<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inPOST('add')) {

    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_ZONES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        \eMarket\Pdo::action("INSERT INTO " . TABLE_ZONES . " SET id=?, name=?, note=?, language=?", [$id, \eMarket\Valid::inPOST('name_zones_' . $x), \eMarket\Valid::inPOST('note_zones'), lang('#lang_all')[$x]]);
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('edit')) {

    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        \eMarket\Pdo::action("UPDATE " . TABLE_ZONES . " SET name=?, note=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_zones_' . $x), \eMarket\Valid::inPOST('note_zones'), \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('delete')) {

    \eMarket\Pdo::action("DELETE FROM " . TABLE_ZONES . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    \eMarket\Pdo::action("DELETE FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [\eMarket\Valid::inPOST('delete')]);

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ZONES . " ORDER BY name", []);
$lines = \eMarket\Func::filterData($sql_data, 'language', lang('#lang_all')[0]);
\eMarket\Pages::table($lines);

require_once('modal/index.php');
