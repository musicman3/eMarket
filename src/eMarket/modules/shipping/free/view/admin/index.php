<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Ecb,
    Pages,
    Valid
};
use eMarket\Core\Modules\Shipping\Free;

require_once('modal/index.php')
?>

<div id="ajax_data" class='hidden' data-jsondata='<?php echo Free::$json_data ?>'></div>

<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th colspan="2"><?php echo Pages::counterPage() ?></th>

                <th>
                    <div class="gap-2 d-flex justify-content-end">

                        <a href="#index" class="btn btn-primary btn-sm bi-plus" data-bs-toggle="modal"></a>

                        <form>
                            <input hidden name="route" value="settings/modules/edit">
                            <input hidden name="backstart" value="<?php echo Pages::$start ?>">
                            <input hidden name="backfinish" value="<?php echo Pages::$finish ?>">
                            <input hidden name="type" value="<?php echo Valid::inGET('type') ?>">
                            <input hidden name="name" value="<?php echo Valid::inGET('name') ?>">
                            <?php if (Pages::$start > 0) { ?>
                                <button type="submit" class="btn btn-primary btn-sm bi-arrow-left-short" formmethod="get"></button>
                            <?php } else { ?>
                                <a type="submit" class="btn btn-primary btn-sm disabled bi-arrow-left-short"></a>
                            <?php } ?>
                        </form>

                        <form>
                            <input hidden name="route" value="settings/modules/edit">
                            <input hidden name="start" value="<?php echo Pages::$start ?>">
                            <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                            <input hidden name="type" value="<?php echo Valid::inGET('type') ?>">
                            <input hidden name="name" value="<?php echo Valid::inGET('name') ?>">
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
                    <th><?php echo lang('modules_shipping_free_admin_shipping_zone') ?></th>
                    <th class="text-center"><?php echo lang('modules_shipping_free_admin_minimum_order_price') ?></th>
                    <th></th>
                </tr>
            <?php } ?>
        </thead>
        <tbody>
            <?php
            for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) {
                ?>
                <tr>
                    <td><?php echo Free::$zones_name[Pages::$table['line']['shipping_zone']] ?></td>
                    <td class="text-center"><?php echo Ecb::formatPrice(Ecb::currencyPrice(Pages::$table['line']['minimum_price'], Pages::$table['line']['currency']), 1) ?></td>
                    <td>
                        <div class="gap-2 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-sm bi-pencil-square" data-bs-toggle="modal" data-bs-target="#index" data-edit="<?php echo Pages::$table['line']['id'] ?>"></button>
                            <form id="form_delete<?php echo Pages::$table['line']['id'] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo Pages::$table['line']['id'] ?>')" enctype="multipart/form-data">
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