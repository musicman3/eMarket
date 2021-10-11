<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages,
    JsonRpc,
    Pages,
    Settings,
    Valid
};
use eMarket\Admin\Orders;

require_once('modal/index.php')
?>

<div id="orders">
    <div class="card">
        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
            <h5 class="card-title col text-center"><?php echo Settings::titlePageGenerator() ?></h5>
        </div>
        <div class="card-body">
            <div id="ajax_data" class='hidden' data-orders='<?php echo Orders::$json_data ?>'></div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-12 px-0">
                <form>
                    <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                    <div class="input-group input-group-sm">
                        <input type="search" id="search" name="search" placeholder="<?php echo lang('search') ?>" class="form-control">
                        <button type="submit" class="btn btn-primary btn-sm bi-search"></button>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="align-middle">
                            <th colspan="7"><?php echo Pages::counterPage() ?></th>

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
                        <?php if (Pages::$count > 0) { ?>
                            <tr class="align-middle">
                                <th><?php echo lang('orders_number') ?></th>
                                <th class="text-center"><?php echo lang('orders_client') ?></th>
                                <th class="text-center"><?php echo lang('orders_email') ?></th>
                                <th class="text-center"><?php echo lang('orders_total') ?></th>
                                <th class="text-center"><?php echo lang('orders_date_added') ?></th>
                                <th class="text-center"><?php echo lang('orders_date_of_change') ?></th>
                                <th class="text-center"><?php echo lang('orders_status') ?></th>
                                <th></th>
                            </tr>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) { ?>
                            <tr class="align-middle">
                                <td><?php echo Pages::$table['line']['id'] ?></td>
                                <td class="text-center"><?php echo json_decode(Pages::$table['line']['customer_data'], true)['firstname'] . ' ' . json_decode(Pages::$table['line']['customer_data'], true)['lastname'] ?></td>
                                <td class="text-center"><?php echo Pages::$table['line']['email'] ?></td>
                                <td class="text-center"><?php echo json_decode(Pages::$table['line']['order_total'], true)['admin']['total_to_pay_format'] ?></td>
                                <td class="text-center"><?php echo Settings::dateLocale(Pages::$table['line']['date_purchased'], '%c') ?></td>
                                <td class="text-center"><?php echo Settings::dateLocale(Pages::$table['line']['last_modified'], '%c') ?></td>
                                <td class="text-center"><?php echo json_decode(Pages::$table['line']['orders_status_history'], true)[0]['admin']['status'] ?></td>
                                <td>
                                    <div class="gap-2 d-flex justify-content-end">
                                        <button onclick="location.href='<?php echo JsonRpc::encodeGetData(Pages::$table['line']['uid'], 'Invoice') ?>'" type="submit" class="btn btn-danger btn-sm bi-file-pdf-fill"> <?php echo lang('blanks_invoice_title') ?></button>
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