<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages,
    Pages,
    Settings,
    Valid
};
use eMarket\Admin\VendorCodes;

require_once('modal/index.php')
?>

<div id="settings_vendor_codes">
    <div class="card">
        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
            <h5 class="card-title row justify-content-between">
                <div class="col-4 text-start">
                    <button type="button" onClick='location.href = "<?php echo Settings::parentPartitionGenerator() ?>"' class="btn btn-primary btn-sm bi-reply"> <?php echo lang('button_back') ?></button>
                </div>
                <div class="col-4 text-center">
                    <?php echo Settings::titlePageGenerator() ?>
                </div>
                <div class="col-4 text-end"></div>
            </h5>
        </div>
        <div class="card-body">
            <div id="ajax_data" class='hidden' data-jsondata='<?php echo VendorCodes::$json_data ?>'></div>

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
                                        <?php if (Pages::$start > 0) { ?>
                                            <button type="submit" class="btn btn-primary btn-sm bi-arrow-left-short" formmethod="get"></button>
                                        <?php } else { ?>
                                            <a type="submit" class="btn btn-primary btn-sm disabled bi-arrow-left-short"></a>
                                        <?php } ?>
                                    </form>

                                    <form>
                                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                        <input hidden name="start" value="<?php echo Pages::$start ?>">
                                        <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                                        <?php if (Pages::$finish != Pages::$count) { ?>
                                            <button type="submit" class="btn btn-primary btn-sm bi-arrow-right-short" formmethod="get"></button>
                                        <?php } else { ?>
                                            <a type="submit" class="btn btn-primary btn-sm disabled bi-arrow-right-short"></a>
                                        <?php } ?>
                                    </form>

                                </div>
                            </th>
                        </tr>
                        <?php if (Pages::$count > 0) { ?>
                            <tr class="align-middle">
                                <th><?php echo lang('vendor_codes_name') ?></th>
                                <th class="text-center"><?php echo lang('vendor_codes_description') ?></th>
                                <th class="text-center"><?php echo lang('default') ?></th>
                                <th></th>
                            </tr>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) { ?>
                            <tr class="align-middle">
                                <td><?php echo Pages::$table['line']['name'] ?></td>
                                <td class="text-center"><?php echo Pages::$table['line']['vendor_code'] ?></td>
                                <?php if (Pages::$table['line']['default_vendor_code'] == 1) { ?>
                                    <td class="text-center"><?php echo lang('confirm-yes') ?></td>
                                <?php } else { ?>
                                    <td class="text-center"><?php echo lang('confirm-no') ?></td>
                                <?php } ?>
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