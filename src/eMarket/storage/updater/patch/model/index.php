<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/**
 * Add Table to configure.php
 *
 * @param string $table table name (table name without prefix)
 */
function addTableToConfigure($table): void {

    $file = file_get_contents(getenv('DOCUMENT_ROOT') . '/storage/configure/configure.php');
    require_once getenv('DOCUMENT_ROOT') . '/storage/configure/configure.php';

    $result = strpos($file, DB_PREFIX . $table);

    if ($result === false) {
        $file .= "define('TABLE_" . strtoupper($table) . "', '" . DB_PREFIX . $table . "');" . "\n";
        file_put_contents(getenv('DOCUMENT_ROOT') . '/storage/configure/configure.php', $file);
    }
}
