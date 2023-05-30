<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Clock\SystemClock,
    Pages,
    Valid,
    Routing
};
use eMarket\Core\Modules\Discount\Sale;

$eMarketDiscountSale = new Sale();
Routing::jsModulesHandler();

require_once('modal/index.php')
?>

<div id="ajax_data" class='hidden' data-jsondata='<?php echo Sale::$json_data ?>'></div>

<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th colspan="5"><?php echo Pages::counterPage() ?></th>

                <th>
                    <div class="gap-2 d-flex justify-content-end">

                        <a href="#index" class="btn btn-primary btn-sm bi-plus" data-bs-toggle="modal"></a>

                        <form>
                            <input hidden name="route" value="modules/edit">
                            <input hidden name="backstart" value="<?php echo Pages::$start ?>">
                            <input hidden name="backfinish" value="<?php echo Pages::$finish ?>">
                            <input hidden name="type" value="<?php echo Valid::inGET('type') ?>">
                            <input hidden name="name" value="<?php echo Valid::inGET('name') ?>">
                            <button type="submit" class="btn btn-primary btn-sm bi-arrow-left-short <?php echo Pages::leftButton() ?>"></button>
                        </form>

                        <form>
                            <input hidden name="route" value="modules/edit">
                            <input hidden name="start" value="<?php echo Pages::$start ?>">
                            <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                            <input hidden name="type" value="<?php echo Valid::inGET('type') ?>">
                            <input hidden name="name" value="<?php echo Valid::inGET('name') ?>">
                            <button type="submit" class="btn btn-primary btn-sm bi-arrow-right-short <?php echo Pages::rightButton() ?>"></button>
                        </form>

                    </div>
                </th>
            </tr>
            <?php if (Pages::$count > 0) { ?>
                <tr class="align-middle">
                    <th><?php echo lang('modules_discount_sale_admin_name') ?></th>
                    <th class="text-center"><?php echo lang('modules_discount_sale_admin_value') ?></th>
                    <th class="text-center"><?php echo lang('modules_discount_sale_admin_sale_start_date') ?></th>
                    <th class="text-center"><?php echo lang('modules_discount_sale_admin_sale_end_date') ?></th>
                    <th class="text-center"><?php echo lang('default') ?></th>
                    <th></th>
                </tr>
            <?php } ?>
        </thead>
        <tbody>
            <?php
            for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) {
                if (Sale::$this_time > SystemClock::getUnixTime(Pages::$table['line']['date_end'])) {
                    $active = ' class="danger"';
                } else {
                    $active = '';
                }
                ?>
                <tr<?php echo $active ?>>

                    <td><?php echo Pages::$table['line']['name'] ?></td>
                    <td class="text-center"><?php echo Pages::$table['line']['sale_value'] ?></td>
                    <td class="text-center"><?php echo SystemClock::getDate(Pages::$table['line']['date_start']); ?></td>
                    <td class="text-center"><?php echo SystemClock::getDate(Pages::$table['line']['date_end']); ?></td>
                    <td class="text-center"><?php echo Sale::defaultText() ?></td>
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