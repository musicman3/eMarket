<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Класс для авторизации пользователей / Class for user authorization
 *
 * @package Autorize
 * @author eMarket
 * 
 */
class Autorize {
    
    public static $CUSTOMER;

    /**
     * Авторизация сессиями для Административной панели / Session authorization for Admin Panel
     *
     * @return string TRUE
     */
    public static function sessionAdmin() {

        // ЕСЛИ В АДМИНИСТРАТИВНОЙ ПАНЕЛИ
        if (\eMarket\Set::path() == 'admin' && \eMarket\Set::titleDir() != 'login') {

            session_start();

            if (isset($_SESSION['session_start']) && (time() - $_SESSION['session_start']) / 60 > \eMarket\Set::sessionExprTime()) {
                unset($_SESSION['login']);
                unset($_SESSION['pass']);
                unset($_SESSION['session_start']);
                $_SESSION['session_page'] = \eMarket\Valid::inSERVER('REQUEST_URI');
                header('Location: ?route=login');
                exit;
            }
            $_SESSION['session_start'] = time();

            if (!isset($_SESSION['login'])) {
                unset($_SESSION['login']);
                unset($_SESSION['pass']);
                $_SESSION['session_page'] = \eMarket\Valid::inSERVER('REQUEST_URI');
                header('Location: ?route=login');
                exit;
            } else {
                $_SESSION['DEFAULT_LANGUAGE'] = \eMarket\Pdo::selectPrepare("SELECT language FROM " . TABLE_ADMINISTRATORS . " WHERE login=? AND password=?", [$_SESSION['login'], $_SESSION['pass']]);

                return TRUE;
            }
        }
    }

    /**
     * Авторизация сессиями для Каталога / Session authorization for Catalog
     *
     * @return string TRUE|FALSE
     */
    public static function sessionCatalog() {

        if (\eMarket\Set::path() == 'catalog') {

            session_start();
            if (isset($_SESSION['email_customer'])) {
                $customer_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
            } else {
                $customer_data = null;
            }

            if (isset($_SESSION['customer_session_start']) && (time() - $_SESSION['customer_session_start']) / 60 > \eMarket\Set::sessionExprTime() OR $customer_data['status'] == 0) {
                unset($_SESSION['password_customer']);
                unset($_SESSION['email_customer']);
                unset($_SESSION['customer_session_start']);
                return FALSE;
            }
            $_SESSION['customer_session_start'] = time();

            if (!isset($_SESSION['email_customer'])) {
                self::$CUSTOMER = FALSE;
            } else {
                self::$CUSTOMER = $customer_data;
            }
        }
    }

    /**
     * Хэширование пароля / Password hashing
     *
     * @param string $password (пароль / password)
     * @return string $password_hash (password hash)
     */
    public static function passwordHash($password) {

        if (HASH_METHOD == 'PASSWORD_DEFAULT') {
            $options = ['cost' => 10];
            $METHOD = PASSWORD_DEFAULT;
        }
        if (HASH_METHOD == 'PASSWORD_BCRYPT') {
            $options = ['cost' => 10];
            $METHOD = PASSWORD_BCRYPT;
        }
        if (HASH_METHOD == 'PASSWORD_ARGON2I') {
            $options = ['time_cost' => 2];
            $METHOD = PASSWORD_ARGON2I;
        }
        $password_hash = password_hash($password, $METHOD, $options);
        return $password_hash;
    }

}

?>