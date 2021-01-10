<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inPOST('delete') == 'delete' && file_exists(ROOT . '/model/work/errors.log')) {
    unlink(ROOT . '/model/work/errors.log');

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}


if (file_exists(ROOT . '/model/work/errors.log')) {
    $lines = array_reverse(file(ROOT . '/model/work/errors.log'));
} else {
    $lines = [];
}

$lines_on_page = \eMarket\Settings::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::postLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];
