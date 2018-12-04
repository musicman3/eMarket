<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Other;

class Messages {

    /**
     * Удобное отображение массива при отладке
     *
     * @param строка $a
     * @param строка $b
     * @return <div>сообщение</div>
     */
    public function alert($a, $b) {
        $SET = new \eMarket\Core\Set;
        $VALID = new \eMarket\Core\Valid;
        
        if ($VALID->inPOST('add') OR $VALID->inGET('add') OR $VALID->inPOST('id_edit') OR $VALID->inGET('id_edit') OR $VALID->inPOST('delete') OR $VALID->inGET('delete')) {
            require_once (ROOT . '/view/' . $SET->template() . '/layouts/alert.php');
        }
    }

}

?>