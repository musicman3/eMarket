<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Pdo,
    Settings,
    Valid
};
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\ErrorHandler;

/**
 * Messages
 *
 * @package Messages
 * @author eMarket
 * 
 */
class Messages {

    /**
     * Monolog ErrorHandler logging
     *
     */
    public static function monologErrorHandler() {

        $log = new Logger('eMarket');
        $log->pushHandler(new StreamHandler(getenv('DOCUMENT_ROOT') . '/storage/logs/errors.log', Logger::NOTICE));
        $log->pushHandler(new StreamHandler("php://output", Logger::NOTICE));
        ErrorHandler::register($log);
    }

    /**
     * Logging
     *
     * @param string $type message type (warning/error/success)
     * @param string $page message page
     * @param string $action (add/edit/delete/cut and etc)
     */
    public static function ActionLogging($type, $page = null, $action = null) {
        if (Settings::path() == 'admin') {
            $log = new Logger('eMarket');
            $log->pushHandler(new StreamHandler(getenv('DOCUMENT_ROOT') . '/storage/logs/actions.log', Logger::INFO));
            $staff = 'Unknown user';

            if (isset($_SESSION['login'])) {
                $staff = $_SESSION['login'] . ' - ' . Settings::ipAddress();
            } else {
                $staff = Valid::inPOST('login') . ' - ' . Settings::ipAddress();
            }

            if ($type == 'warning') {
                $log->warning(strtoupper($action), [$page, $staff]);
            }
            if ($type == 'danger') {
                $log->error(strtoupper($action), [$page, $staff]);
            }
            if ($type == 'success') {
                $log->info(strtoupper($action), [$page, $staff]);
            }
        }
    }

    /**
     * Error notifications, success, etc.
     * 
     * param string $action (add/edit/delete/cut and etc)
     * @param string $class Bootstrap class
     * @param string $message Message
     * @param string $time Show time
     * @param string $start Manual call
     *
     */
    public static function alert($action = null, $class = null, $message = null, $time = null, $start = false) {
        if ($message != null && $class != null) {
            $_SESSION['message_marker'] = 'ok';
            if ($time != null) {
                $_SESSION['message'] = [$class, $message, $time, $start, date('H:i')];
                self::ActionLogging($class, '?route=' . Valid::inGET('route'), $action);
            } else {
                $_SESSION['message'] = [$class, $message, 3000, $start, date('H:i')];
                self::ActionLogging($class, '?route=' . Valid::inGET('route'), $action);
            }
            if (Valid::inGET('route') == 'settings/modules/edit') {
                self::alert();
            }
            return true;
        }

        if (isset($_SESSION['message_marker']) && $_SESSION['message_marker'] == 'ok_3') {
            if (isset($_SESSION['message'])) {
                require_once (ROOT . '/view/' . Settings::template() . '/layouts/alert.php');
            }
            unset($_SESSION['message_marker']);
            unset($_SESSION['message']);
        }

        if (Valid::inPostJson('message') == 'ok') {
            if (isset($_SESSION['message'])) {
                require_once (ROOT . '/view/' . Settings::template() . '/layouts/alert.php');
            }
            unset($_SESSION['message_marker']);
            unset($_SESSION['message']);
        }

        if (isset($_SESSION['message_marker']) && $_SESSION['message_marker'] == 'ok_2') {
            $_SESSION['message_marker'] = 'ok_3';
        }

        if (isset($_SESSION['message_marker']) && $_SESSION['message_marker'] == 'ok') {
            $_SESSION['message_marker'] = 'ok_2';
        }

        if (isset($_SESSION['message'][3]) && $_SESSION['message'][3] == TRUE) {
            require_once (ROOT . '/view/' . Settings::template() . '/layouts/alert.php');
            unset($_SESSION['message']);
        }
    }

    /**
     * Providers notifications
     *
     * @param string $to ('To' contact)
     * @param string $body (message)
     */
    public static function sendProviders($to, $body) {

        $active_modules = Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=?", ['providers', '1']);
        foreach ($active_modules as $module) {
            $namespace = '\eMarket\Core\Modules\Providers\\' . ucfirst($module['name']);
            $namespace::data();
            $namespace::send($to, $body);
        }
    }

    /**
     * Email notifications
     *
     * @param string $email_to Recipient's e-mail. Delimiter ";"
     * @param string $subject E-mail subject text
     * @param string $message Html message
     */
    public static function sendMail($email_to, $subject, $message) {

        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->CharSet = 'UTF-8';

        $basic_settings = Pdo::getColAssoc("SELECT * FROM " . TABLE_BASIC_SETTINGS . "", [])[0];

        if ($basic_settings['smtp_status'] == 0) {
            $mail->isSendmail();
            $mail->setFrom($basic_settings['email'], $basic_settings['email_name']);
            $mail->addAddress($email_to);
            $mail->Subject = $subject;
            $mail->msgHTML($message);
            $mail->send();
        }

        if ($basic_settings['smtp_status'] == 1) {

            if ($basic_settings['smtp_auth'] == 0) {
                $smtp_auth = false;
            } else {
                $smtp_auth = true;
            }

            $mail->isSMTP();
            $mail->Host = $basic_settings['host_email'];
            $mail->SMTPAuth = $smtp_auth;
            $mail->Username = $basic_settings['username_email'];
            $mail->Password = $basic_settings['password_email'];
            $mail->SMTPSecure = $basic_settings['smtp_secure'];
            $mail->Port = $basic_settings['smtp_port'];
            $mail->setFrom($basic_settings['email'], $basic_settings['email_name']);
            $mail->addAddress($email_to);
            $mail->Subject = $subject;
            $mail->msgHTML($message);
            $mail->send();
        }
    }

}
