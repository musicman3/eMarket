<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages,
    Pages,
    Settings,
    Valid,
    View
};
use eMarket\Catalog\Orders;

foreach (View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
require_once('modal/index.php')
?>

<div id="alert_block"><?php Messages::alert(); ?></div>
<h1><?php echo lang('orders_book') ?></h1>

<div id="ajax_data" class='hidden' data-orders='<?php echo Orders::$orders_edit ?>'></div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="align-middle">
                <th colspan="4"><?php echo Pages::counterPage() ?></th>

                <th>

                    <div class="gap-2 d-flex justify-content-end">
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
            <tr class="align-middle">
                <th><?php echo lang('orders_number') ?></th>
                <th class="text-center"><?php echo lang('orders_total') ?></th>
                <th class="text-center"><?php echo lang('orders_date_added') ?></th>
                <th class="text-center"><?php echo lang('orders_status') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (Pages::$count > 0) {
                for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) {
                    ?>
                    <tr class="align-middle">
                        <td><?php echo Pages::$table['line']['id'] ?></td>
                        <td class="text-center"><?php echo json_decode(Pages::$table['line']['order_total'], true)['customer']['total_to_pay_format'] ?></td>
                        <td class="text-center"><?php echo Settings::dateLocale(Pages::$table['line']['date_purchased'], '%c') ?></td>
                        <td class="text-center"><?php echo json_decode(Pages::$table['line']['orders_status_history'], true)[0]['customer']['status'] ?></td>

                        <td>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary btn-sm bi-pencil-square" data-bs-toggle="modal" data-bs-target="#index" data-edit="<?php echo Pages::$table['line']['id'] ?>"></button>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>
</div>
