<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Messages,
    Pages,
    Valid,
    Settings
};
?>

<div id="error_log">
    <div class="panel panel-default">

        <div class="panel-heading">
            <div id="alert_block"><?php Messages::alert(); ?></div>
            <h3 class="panel-title">
                <?php echo Settings::titlePageGenerator() ?>
            </h3>
        </div>
        <?php if (file_exists(ROOT . '/storage/logs/errors.log') == true) { ?>
            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php echo Pages::counterPage() ?></th>

                                <th>
                                    <div class="flexbox">
                                        <form id="form_delete_log" name="form_delete_log" action="javascript:void(null);" onsubmit="Ajax.callDelete('_log')" enctype="multipart/form-data">
                                            <input hidden name="delete" value="delete">
                                            <div class="b-left"><button type="submit" name="delete_but" class="btn btn-primary btn-sm" data-placement="left" data-bs-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="bi-trash"> </span></button></div>
                                        </form>
                                        <form>
                                            <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                            <input hidden name="backstart" value="<?php echo Pages::$start ?>">
                                            <input hidden name="backfinish" value="<?php echo Pages::$finish ?>">
                                            <div class="b-left">
                                                <?php if (Pages::$start > 0) { ?>
                                                    <button type="submit" class="btn btn-primary btn-sm" formmethod="get"><span class="bi-arrow-left-short"></span></button>
                                                <?php } else { ?>
                                                    <a type="submit" class="btn btn-primary btn-sm disabled"><span class="bi-arrow-left-short"></span></a>
                                                <?php } ?>
                                            </div>
                                        </form>
                                        <form>
                                            <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                            <input hidden name="start" value="<?php echo Pages::$start ?>">
                                            <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                                            <div>
                                                <?php if (Pages::$finish != Pages::$count) { ?>
                                                    <button type="submit" class="btn btn-primary btn-sm" formmethod="get"><span class="bi-arrow-right-short"></span></button>
                                                <?php } else { ?>
                                                    <a type="submit" class="btn btn-primary btn-sm disabled"><span class="bi-arrow-right-short"></span></a>
                                                <?php } ?>
                                            </div>
                                        </form>
                                    </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) {

                                if (isset(Pages::$table['line']) == TRUE) {

                                    if (strrpos(Pages::$table['line'], 'PHP Notice:') == TRUE) {
                                        ?><tr class="success"><td colspan="2"><?php echo Pages::$table['line'] . '</td></tr>'; ?><?php
                                    } elseif
                                    (strrpos(Pages::$table['line'], 'PHP Warning:') == TRUE) {
                                        ?><tr class="warning"><td colspan="2"><?php echo Pages::$table['line'] . '</td></tr>'; ?><?php
                                            } elseif
                                            (strrpos(Pages::$table['line'], 'PHP Catchable fatal error:') == TRUE) {
                                                ?><tr class="danger"><td colspan="2"><?php echo Pages::$table['line'] . '</td></tr>'; ?><?php
                                            } elseif
                                            (strrpos(Pages::$table['line'], 'PHP Fatal error:') == TRUE) {
                                                ?><tr class="danger"><td colspan="2"><?php echo Pages::$table['line'] . '</td></tr>'; ?><?php
                                            } elseif
                                            (strrpos(Pages::$table['line'], 'PHP Parse error:') == TRUE) {
                                                ?><tr class="info"><td colspan="2"><?php echo Pages::$table['line'] . '</td></tr>'; ?><?php } else {
                                                ?><tr><td colspan="2"><?php
                                                echo Pages::$table['line'] . '</td></tr>';
                                            }
                                        }
                                    }
                                    ?>

                        </tbody>

                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="modal-body"><?php echo lang('no_listing') ?></div>
        <?php } ?>
    </div>
</div>