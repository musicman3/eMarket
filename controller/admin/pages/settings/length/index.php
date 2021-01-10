<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inPOST('add')) {

    if (\eMarket\Valid::inPOST('default_length')) {
        $default_length = 1;
    } else {
        $default_length = 0;
    }

    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_LENGTH . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    if ($id > 1 && $default_length != 0) {
        \eMarket\Pdo::action("UPDATE " . TABLE_LENGTH . " SET default_length=?", [0]);

        $value_length_all = \eMarket\Pdo::getColAssoc("SELECT id, value_length, language FROM " . TABLE_LENGTH, []);
        $count_value_length_all = count($value_length_all);
        for ($x = 0; $x < $count_value_length_all; $x++) {
            \eMarket\Pdo::action("UPDATE " . TABLE_LENGTH . " SET value_length=? WHERE id=? AND language=?", [($value_length_all[$x]['value_length'] / \eMarket\Valid::inPOST('value_length')), $value_length_all[$x]['id'], $value_length_all[$x]['language']]);
        }

        for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
            \eMarket\Pdo::action("INSERT INTO " . TABLE_LENGTH . " SET id=?, name=?, language=?, code=?, value_length=?, default_length=?", [$id, \eMarket\Valid::inPOST('name_length_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('code_length_' . $x), 1, $default_length]);
        }
    } else {

        for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
            \eMarket\Pdo::action("INSERT INTO " . TABLE_LENGTH . " SET id=?, name=?, language=?, code=?, value_length=?, default_length=?", [$id, \eMarket\Valid::inPOST('name_length_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('code_length_' . $x), \eMarket\Valid::inPOST('value_length'), $default_length]);
        }
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('edit')) {

    if (\eMarket\Valid::inPOST('default_length')) {
        $default_length = 1;
    } else {
        $default_length = 0;
    }

    if ($default_length != 0) {
        \eMarket\Pdo::action("UPDATE " . TABLE_LENGTH . " SET default_length=?", [0]);

        $value_length_all = \eMarket\Pdo::getColAssoc("SELECT id, value_length, language FROM " . TABLE_LENGTH, []);
        $count_value_length_all = count($value_length_all);
        for ($x = 0; $x < $count_value_length_all; $x++) {
            \eMarket\Pdo::action("UPDATE " . TABLE_LENGTH . " SET value_length=? WHERE id=? AND language=?", [($value_length_all[$x]['value_length'] / \eMarket\Valid::inPOST('value_length')), $value_length_all[$x]['id'], $value_length_all[$x]['language']]);
        }

        for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
            \eMarket\Pdo::action("UPDATE " . TABLE_LENGTH . " SET name=?, code=?, value_length=?, default_length=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_length_' . $x), \eMarket\Valid::inPOST('code_length_' . $x), 1, $default_length, \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
        }
    } else {

        for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
            \eMarket\Pdo::action("UPDATE " . TABLE_LENGTH . " SET name=?, code=?, value_length=?, default_length=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_length_' . $x), \eMarket\Valid::inPOST('code_length_' . $x), \eMarket\Valid::inPOST('value_length'), $default_length, \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
        }
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('delete')) {
    \eMarket\Pdo::action("DELETE FROM " . TABLE_LENGTH . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_LENGTH . " ORDER BY id DESC", []);
$lines = \eMarket\Func::filterData($sql_data, 'language', lang('#lang_all')[0]);
$lines_on_page = \eMarket\Settings::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::getLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

require_once('modal/index.php');
