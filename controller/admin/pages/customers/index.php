<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inPOST('status')) {
    
    $status_data = \eMarket\Pdo::getCell("SELECT status FROM " . TABLE_CUSTOMERS . " WHERE id=?", [\eMarket\Valid::inPOST('status')]);

    if ($status_data == 0) {
        $status = 1;
    } else {
        $status = 0;
    }
    
    \eMarket\Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET status=? WHERE id=?", [$status, \eMarket\Valid::inPOST('status')]);

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('delete')) {
    
    \eMarket\Pdo::action("DELETE FROM " . TABLE_CUSTOMERS . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

$search = '%' . \eMarket\Valid::inGET('search') . '%';
if (\eMarket\Valid::inGET('search')) {
    $lines = \eMarket\Pdo::getColRow("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE firstname LIKE? OR lastname LIKE? OR middle_name LIKE? OR email LIKE? ORDER BY id DESC", [$search, $search, $search, $search]);
} else {
    $lines = \eMarket\Pdo::getColRow("SELECT * FROM " . TABLE_CUSTOMERS . " ORDER BY id DESC", []);
}
$lines_on_page = \eMarket\Settings::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::getLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];
