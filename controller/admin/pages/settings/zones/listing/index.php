<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inPOST('zone_id')) {
    $zones_id = (int) \eMarket\Valid::inPOST('zone_id');
}

if (\eMarket\Valid::inGET('zone_id')) {
    $zones_id = (int) \eMarket\Valid::inGET('zone_id');
}

if (\eMarket\Valid::inPOST('add')) {

    \eMarket\Pdo::action("DELETE FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [$zones_id]);

    if (empty(\eMarket\Valid::inPOST('multiselect')) == FALSE) {
        $multiselect = \eMarket\Func::arrayExplode(\eMarket\Valid::inPOST('multiselect'), '-');
        for ($x = 0; $x < count($multiselect); $x++) {
            \eMarket\Pdo::action("INSERT INTO " . TABLE_ZONES_VALUE . " SET country_id=?, regions_id=?, zones_id=?", [$multiselect[$x][0], $multiselect[$x][1], $zones_id]);
        }
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

$countries_multiselect_temp = \eMarket\Pdo::getColRow("SELECT id, name FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$countries_multiselect = array_column($countries_multiselect_temp, 1, 0);
asort($countries_multiselect);
$regions_multiselect = \eMarket\Pdo::getColAssoc("SELECT id, country_id, name, region_code  FROM " . TABLE_REGIONS . " WHERE language=?", [lang('#lang_all')[0]]);
$regions = \eMarket\Pdo::getColAssoc("SELECT country_id, regions_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [$zones_id]);

$lines_temp = \eMarket\Pdo::getColRow("SELECT country_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [$zones_id]);
$lines = array_values(array_unique($lines_temp, SORT_REGULAR));
$lines_on_page = \eMarket\Settings::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::getLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

$text_arr = [];
for ($y = $start; $y < $finish; $y++) {
    $text = '| ';
    for ($x = 0; $x < count($regions); $x++) {
        if (isset($regions[$x]['country_id']) == TRUE && isset($lines[$y][0]) == TRUE && $regions[$x]['country_id'] == $lines[$y][0]) {
            $text .= \eMarket\Func::filterArrayToKeyAssoc($regions_multiselect, 'country_id', $regions[$x]['country_id'], 'name', 'id')[$regions[$x]['regions_id']] . ' | ';
        }
    }
    array_push($text_arr, $text);
}
