<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Middleware;

use eMarket\Core\{
    Settings,
    Lang
};

/**
 * Class for install authorization
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class InstallAuthorize {

    public static $csrf_token = FALSE;
    public static $permission = FALSE;

    /**
     * Constructor
     *
     */
    public function __construct() {

        session_start();

        if (Settings::path() == 'install' && !$this->installVerify()) {
            echo 'Error! Installation already completed!';
            exit;
        }
        // Load Languages
        new Lang();
    }

    /**
     * Checking for install
     * Thanks to alexanderpas (https://github.com/alexanderpas)
     *
     * @return bool TRUE/FALSE
     */
    private function installVerify(): bool {
        if (file_exists(getenv('DOCUMENT_ROOT') . '/storage/configure/configure.php')) {
            return FALSE;
        }
        return TRUE;
    }
}
