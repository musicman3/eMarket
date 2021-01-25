<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Messages,
    Pages,
    Settings,
    Valid
};
use \eMarket\Admin\Orders;

require_once('modal/index.php')
?>

<div id="orders">
    <div class="card">
        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
            <h3 class="card-title">
                <?php echo Settings::titlePageGenerator() ?>
            </h3>
        </div>
        <div class="modal-body">
            <div id="ajax_data" class='hidden' data-orders='<?php echo Orders::$json_data ?>'></div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 offset-0">
                <form>
                    <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                    <div class="input-group">
                        <input type="search" id="search" name="search" placeholder="<?php echo lang('search') ?>" class="form-control">
                        <button type="submit" class="bi-search btn btn-primary"></button>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="align-middle">
                            <th colspan="7"><?php echo Pages::counterPage() ?></th>

                            <th>
                                <div class="flexbox">
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
                                <td class="text-center"><?php echo json_decode(Pages::$table['line']['customer_data'], 1)['firstname'] . ' ' . json_decode(Pages::$table['line']['customer_data'], 1)['lastname'] ?></td>
                                <td class="text-center"><?php echo Pages::$table['line']['email'] ?></td>
                                <td class="text-center"><?php echo json_decode(Pages::$table['line']['order_total'], 1)['admin']['total_to_pay_format'] ?></td>
                                <td class="text-center"><?php echo Settings::dateLocale(Pages::$table['line']['date_purchased'], '%c') ?></td>
                                <td class="text-center"><?php echo Settings::dateLocale(Pages::$table['line']['last_modified'], '%c') ?></td>
                                <td class="text-center"><?php echo json_decode(Pages::$table['line']['orders_status_history'], 1)[0]['admin']['status'] ?></td>
                                <td>
                                    <div class="flexbox">
                                        <div class="b-left">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#index" data-edit="<?php echo Pages::$table['line']['id'] ?>"><span class="bi-pencil-square"></span></button>
                                        </div>
                                        <form id="form_delete<?php echo Pages::$table['line']['id'] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo Pages::$table['line']['id'] ?>')" enctype="multipart/form-data">
                                            <input hidden name="delete" value="<?php echo Pages::$table['line']['id'] ?>">
                                            <div>
                                                <button type="submit" name="delete_but" class="btn btn-primary btn-sm" data-bs-placement="left" data-bs-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="bi-trash"> </span></button>
                                            </div>
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