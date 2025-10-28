<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use Cruder\Db;

Db::config(
        [
            DB_TYPE =>
            [
                'db_driver' => DB_TYPE,
                'db_server' => DB_SERVER,
                'db_name' => DB_NAME,
                'db_username' => DB_USERNAME,
                'db_password' => DB_PASSWORD,
                'db_prefix' => DB_PREFIX,
                'db_port' => DB_PORT,
                'db_family' => DB_FAMILY,
                'db_charset' => 'utf8mb4',
                'db_collate' => 'utf8mb4_unicode_ci',
                'db_path' => ROOT . '/storage/databases/sqlite.db3'
            ]
        ]
);
Db::use(DB_TYPE)->transactions('off');
