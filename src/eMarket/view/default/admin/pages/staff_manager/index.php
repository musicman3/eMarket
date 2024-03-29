<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages,
    Pages,
    Valid
};
use eMarket\Admin\StaffManager;

require_once('modal/index.php')
?>

<div id="staff_manager">
    <div class="card">
        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
        </div>
        <div class="card-body">
            <div id="ajax_data" class='hidden' data-jsondata='<?php echo StaffManager::$json_data ?>'></div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="align-middle">
                            <th colspan="3"><?php echo Pages::counterPage() ?></th>

                            <th>

                                <div class="gap-2 d-flex justify-content-end">

                                    <a href="#index" class="btn btn-primary btn-sm bi-plus" data-bs-toggle="modal"></a>

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
                        <?php if (Pages::$count > 0) { ?>
                            <tr class="align-middle">
                                <th class="sortleft"></th>
                                <th><?php echo lang('staff_manager_group') ?></th>
                                <th class="text-center"><?php echo lang('staff_manager_note') ?></th>
                                <th></th>
                            </tr>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) { ?>
                            <tr class="align-middle">
                                <td class="sortleft">
                                    <form>
                                        <input hidden name="route" value="staff_manager/staff">
                                        <input hidden name="staff_manager_id" value="<?php echo Pages::$table['line']['id'] ?>">
                                        <button type="submit" class="btn btn-primary btn-sm bi-gear-fill"></button>
                                    </form>
                                </td>
                                <td><?php echo Pages::$table['line']['name'] ?></td>
                                <td class="text-center"><?php echo Pages::$table['line']['note'] ?></td>
                                <td>
                                    <div class="gap-2 d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary btn-sm bi-pencil-square" data-bs-toggle="modal" data-bs-target="#index" data-edit="<?php echo Pages::$table['line']['id'] ?>"></button>
                                        <form id="form_delete<?php echo Pages::$table['line']['id'] ?>" name="form_delete" action="javascript:void(null);" enctype="multipart/form-data">
                                            <input hidden name="delete" value="<?php echo Pages::$table['line']['id'] ?>">
                                            <button type="button" name="delete_but" class="btn btn-primary btn-sm bi-trash" onclick="Confirmation.del('<?php echo Pages::$table['line']['id'] ?>')"></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>