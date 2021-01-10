<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inPOST('add')) {

    if (\eMarket\Valid::inPOST('tax_type')) {
        $tax_type = 1;
    } else {
        $tax_type = 0;
    }

    if (\eMarket\Valid::inPOST('fixed')) {
        $fixed = 1;
    } else {
        $fixed = 0;
    }

    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_TAXES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        \eMarket\Pdo::action("INSERT INTO " . TABLE_TAXES . " SET id=?, name=?, language=?, rate=?, tax_type=?, zones_id=?, fixed=?, currency=?", [$id, \eMarket\Valid::inPOST('name_taxes_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('rate_taxes'), $tax_type, \eMarket\Valid::inPOST('zones_id'), $fixed, \eMarket\Settings::currencyDefault()[0]]);
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('edit')) {

    if (\eMarket\Valid::inPOST('tax_type')) {
        $tax_type = 1;
    } else {
        $tax_type = 0;
    }

    if (\eMarket\Valid::inPOST('fixed')) {
        $fixed = 1;
    } else {
        $fixed = 0;
    }

    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        \eMarket\Pdo::action("UPDATE " . TABLE_TAXES . " SET name=?, rate=?, tax_type=?, zones_id=?, fixed=?, currency=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_taxes_' . $x), \eMarket\Valid::inPOST('rate_taxes'), $tax_type, \eMarket\Valid::inPOST('zones_id'), $fixed, \eMarket\Settings::currencyDefault()[0], \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('delete')) {
    \eMarket\Pdo::action("DELETE FROM " . TABLE_TAXES . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

$zones = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ZONES . " WHERE language=?", [lang('#lang_all')[0]]);

$zones_names = [];
foreach ($zones as $zones_val) {
    $zones_names[$zones_val['id']] = $zones_val['name'];
}

$value_6 = [0 => sprintf(lang('taxes_value'), \eMarket\Settings::currencyDefault()[2]), 1 => lang('taxes_percent')];
$value_4 = [0 => lang('taxes_separately'), 1 => lang('taxes_included')];

$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_TAXES . " ORDER BY id DESC", []);
$lines = \eMarket\Func::filterData($sql_data, 'language', lang('#lang_all')[0]);
$lines_on_page = \eMarket\Settings::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::getLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

require_once('modal/index.php');
