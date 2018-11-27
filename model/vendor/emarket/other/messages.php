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
        global $VALID;
        //Выводим уведомление об успешном действии
        if ($VALID->inPOST('add') OR $VALID->inGET('add') OR $VALID->inPOST('id_edit') OR $VALID->inGET('id_edit') OR $VALID->inPOST('delete') OR $VALID->inGET('delete')) {

            ?>
            <div id="alert" class="alert alert-<?php echo $a ?> alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $b ?>
            </div>
            <?php
        }

        ?>
        <!--Автозакрытие уведомлений-->
        <script>
            $(function () {
                window.setTimeout(function () {
                    $('#alert').alert('close');
                }, 30000);
            });
        </script>
        <?php
    }

}

?>