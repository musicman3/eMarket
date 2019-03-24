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

}

?>