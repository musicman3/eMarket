<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inPOST('add')) {

    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_MANUFACTURERS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        \eMarket\Pdo::action("INSERT INTO " . TABLE_MANUFACTURERS . " SET id=?, name=?, language=?, site=?, logo=?", [$id, \eMarket\Valid::inPOST('name_manufacturers_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('site_manufacturers'), json_encode([])]);
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('edit')) {

    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        \eMarket\Pdo::action("UPDATE " . TABLE_MANUFACTURERS . " SET name=?, site=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_manufacturers_' . $x), \eMarket\Valid::inPOST('site_manufacturers'), \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

// add before delete
$resize_param = [];
array_push($resize_param, ['125', '94']); // width, height
//array_push($resize_param, ['200','150']);
//array_push($resize_param, ['325','244']);
//array_push($resize_param, ['525','394']);
//array_push($resize_param, ['850','638']);

\eMarket\Files::imgUpload(TABLE_MANUFACTURERS, 'manufacturers', $resize_param);

if (\eMarket\Valid::inPOST('delete')) {

    \eMarket\Pdo::action("DELETE FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MANUFACTURERS . " ORDER BY id DESC", []);
$lines = \eMarket\Func::filterData($sql_data, 'language', lang('#lang_all')[0]);
\eMarket\Pages::table($lines);

require_once('modal/index.php');
