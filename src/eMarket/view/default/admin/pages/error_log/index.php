<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages,
    Pages,
    Valid,
    Settings
};
use eMarket\Admin\ErrorLog;
?>

<div id="error_log">
    <div class="card">

        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
        </div>

        <div class="card-body">
            <?php if (file_exists(ROOT . '/storage/logs/errors.log') == true) { ?>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr class="align-middle">
                                <th><?php echo Pages::counterPage() ?></th>

                                <th>
                                    <div class="gap-2 d-flex justify-content-end">

                                        <form id="form_delete_log" name="form_delete_log" action="javascript:void(null);" enctype="multipart/form-data">
                                            <input hidden name="delete" value="delete">
                                            <button type="button" name="delete_but" class="btn btn-primary btn-sm bi-trash" onclick="Confirmation.del('_log')"></button>
                                        </form>

                                        <form>
                                            <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                            <input hidden name="backstart" value="<?php echo Pages::$start ?>">
                                            <input hidden name="backfinish" value="<?php echo Pages::$finish ?>">
                                            <button type="submit" class="btn btn-primary btn-sm bi-arrow-left-short <?php echo Pages::leftButton() ?>"></button>
                                        </form>

                                        <form>
                                            <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                            <input hidden name="start" value="<?php echo Pages::$start ?>">
                                            <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                                            <button type="submit" class="btn btn-primary btn-sm bi-arrow-right-short <?php echo Pages::rightButton() ?>"></button>
                                        </form>

                                    </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) {

                                if (isset(Pages::$table['line']) == TRUE) {
                                    ?>
                                    <tr class="<?php echo ErrorLog::errorClass(Pages::$table['line']) ?> align-middle"><td colspan="2"><?php echo Pages::$table['line'] ?></td></tr>
                                        <?php
                                    }
                                }
                                ?>

                        </tbody>

                    </table>
                </div>
                <?php
            } else {
                echo lang('no_listing');
            }
            ?>
        </div>
    </div>
</div>