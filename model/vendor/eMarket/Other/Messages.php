<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Other;

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
     */
    public function alert() {
        $SET = new \eMarket\Core\Set;
        $VALID = new \eMarket\Core\Valid;

        if ($VALID->inPOST('add') OR $VALID->inPOST('edit')OR $VALID->inPOST('delete') OR $VALID->inPOST('idsx_paste_key')) {
            $_SESSION['message_marker'] = 'ok';
        }

        // При POST и GET по ajax + обновление страницы ШАГ 3 (обновление редиректом)
        if (isset($_SESSION['message_marker']) && $_SESSION['message_marker'] == 'ok_3') {
            if (isset($_SESSION['message'])) {
                require_once (ROOT . '/view/' . $SET->template() . '/layouts/alert.php');
            }
            unset($_SESSION['message_marker']);
            unset($_SESSION['message']);
        }
        // При POST и GET по ajax + обновление страницы ШАГ 4 (обновление по ajax)
        if ($VALID->inGET('modify')) {
            if (isset($_SESSION['message'])) {
                require_once (ROOT . '/view/' . $SET->template() . '/layouts/alert.php');
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
            require_once (ROOT . '/view/' . $SET->template() . '/layouts/alert.php');
            unset($_SESSION['message']);
        }
    }

    /**
     * Уведомления на E-Mail
     *
     */
    public function sendRegisterMail($email_to) {

        $PDO = new \eMarket\Core\Pdo;
        $mail = new \PHPMailer\PHPMailer\PHPMailer();

        $basic_settings = $PDO->getColAssoc("SELECT * FROM " . TABLE_BASIC_SETTINGS . "", []);

        if ($basic_settings['smtp_status'] == 0) {
            $mail->isSendmail();
            $mail->setFrom($basic_settings['email'], $basic_settings['email_name']);
            $mail->addAddress($email_to);
            $mail->Subject = 'PHPMailer mail() test';
            $mail->msgHTML('<p><strong>«Hello, world!» </strong></p>');
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
            $mail->Subject = 'PHPMailer mail() test';
            $mail->msgHTML('<p><strong>«Hello, world!» </strong></p>');
            $mail->send();
        }
    }

}

?>