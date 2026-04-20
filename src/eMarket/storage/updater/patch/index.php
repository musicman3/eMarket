<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

require_once getenv('DOCUMENT_ROOT') . '/storage/updater/patch/model/index.php';

// Add settings
addTableToConfigure('contacts');
addTableToConfigure('about_us');
addTableToConfigure('shipping');
