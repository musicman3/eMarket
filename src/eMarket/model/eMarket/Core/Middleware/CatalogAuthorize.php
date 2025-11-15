<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Middleware;

use eMarket\Core\{
    Cryptography,
    Settings,
    Lang,
    Clock\SystemClock
};
use \eMarket\Catalog\{
    Cart
};
use R2D2\R2\Valid;
use Cruder\Db;

/**
 * Class for catalog authorization
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class CatalogAuthorize {

    public static $customer;
    public static $csrf_token = FALSE;

    /**
     * Constructor
     *
     */
    public function __construct() {

        if (Valid::inGET('route') == 'login' || Settings::path() == 'uploads') {
            return;
        }

        session_start();
        $this->csrfVerification();

        $this->catalog();
        // Load Languages
        new Lang();
        new Cart();
    }

    /**
     * CSRF Token
     *
     * @return string CSRF token
     */
    public static function csrfToken(): string {

        if (!self::$csrf_token) {
            self::$csrf_token = Cryptography::getToken(32);
            $_SESSION['csrf_token_' . Settings::path()] = self::$csrf_token;
        }
        return self::$csrf_token;
    }

    /**
     * CSRF Verification
     *
     */
    private function csrfVerification(): void {

        if (!isset($_SESSION[Settings::$csrf[Settings::path()]])) {
            $csrf_session_token = self::csrfToken();
        } else {
            $csrf_session_token = $_SESSION[Settings::$csrf[Settings::path()]];
        }

        if (Valid::isPOST()) {
            if (!Valid::inPOST('csrf_token') || Valid::inPOST('csrf_token') != $csrf_session_token) {
                echo 'CSRF Token Error!';
                exit;
            }
        }

        if (Valid::isPostJson()) {
            if (Settings::path() != 'JsonRpc') {
                if (!Valid::inPostJson('csrf_token') || Valid::inPostJson('csrf_token') != $csrf_session_token) {
                    echo 'CSRF Token Error!';
                    exit;
                }
            }
        }
    }

    /**
     * Session authorization for Catalog
     *
     * @return bool TRUE|FALSE
     */
    private function catalog(): bool {

        $new_datestamp = SystemClock::nowUnixTime();

        if (isset($_SESSION['customer_email'])) {

            $customer_data = Db::connect()
                            ->read(TABLE_CUSTOMERS)
                            ->selectAssoc('*')
                            ->where('email=', $_SESSION['customer_email'])
                            ->save()[0];
        } else {
            $customer_data['status'] = 0;
        }

        if (isset($_SESSION['customer_session_start']) && ($new_datestamp - $_SESSION['customer_session_start']) / 60 > Settings::adminSessionTime() || $customer_data['status'] == 0) {
            unset($_SESSION['customer_password']);
            unset($_SESSION['customer_email']);
            unset($_SESSION['customer_session_start']);
            return FALSE;
        }
        $_SESSION['customer_session_start'] = $new_datestamp;

        if (!isset($_SESSION['customer_email'])) {
            self::$customer = FALSE;
        } else {
            self::$customer = $customer_data;
        }

        return TRUE;
    }
}
