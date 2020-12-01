<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Класс для работы сообщениями или уведомлениями
 *
 * @package Messages
 * @author eMarket
 * 
 */
class Messages {

    /**
     * Уведомления об ошибках, успехе и т.п.
     * 
     * @param string $class (класс bootstrap)
     * @param string $message (сообщение)
     * @param string $time (время показа)
     * @param string $start (если показываем самостоятельно)
     *
     */
    public static function alert($class = null, $message = null, $time = null, $start = false) {

        if ($message != null && $class != null) {
            $_SESSION['message_marker'] = 'ok';
            if ($time != null) {
                $_SESSION['message'] = [$class, $message, $time, $start];
            } else {
                $_SESSION['message'] = [$class, $message, 3000, $start];
            }
            return true;
        }

        // При POST и GET по ajax + обновление страницы ШАГ 3 (обновление редиректом)
        if (isset($_SESSION['message_marker']) && $_SESSION['message_marker'] == 'ok_3') {
            if (isset($_SESSION['message'])) {
                require_once (ROOT . '/view/' . \eMarket\Set::template() . '/layouts/alert.php');
            }
            unset($_SESSION['message_marker']);
            unset($_SESSION['message']);
        }
        // При POST и GET по ajax + обновление страницы ШАГ 4 (обновление по ajax)
        if (\eMarket\Valid::inGET('modify')) {
            if (isset($_SESSION['message'])) {
                require_once (ROOT . '/view/' . \eMarket\Set::template() . '/layouts/alert.php');
            }
        }

        // При POST и GET по ajax + обновление страницы ШАГ 2
        if (isset($_SESSION['message_marker']) && $_SESSION['message_marker'] == 'ok_2') {
            $_SESSION['message_marker'] = 'ok_3';
        }
        // При POST и GET по ajax + обновление страницы ШАГ 1
        if (isset($_SESSION['message_marker']) && $_SESSION['message_marker'] == 'ok') {
            $_SESSION['message_marker'] = 'ok_2';
        }

        // Если вызываем самостоятельно
        if (isset($_SESSION['message'][3]) && $_SESSION['message'][3] == TRUE) {
            require_once (ROOT . '/view/' . \eMarket\Set::template() . '/layouts/alert.php');
            unset($_SESSION['message']);
        }
    }

    /**
     * Уведомления на E-Mail
     *
     * @param string $email_to (E-Mail получателя. Разделитель ";")
     * @param string $subject (текст темы E-Mail)
     * @param string $message (Сообщение в html)
     */
    public static function sendMail($email_to, $subject, $message) {

        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->CharSet = 'UTF-8';

        $basic_settings = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_BASIC_SETTINGS . "", [])[0];

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

?>