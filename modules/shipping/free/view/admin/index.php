<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
require_once('modal/index.php')
?>

<div id="ajax_data" class='hidden' data-jsondata='<?php echo \eMarket\Core\Modules\Shipping\Free::$json_data ?>'></div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th colspan="2"><?php echo \eMarket\Core\Pages::counterPage() ?></th>

                <th>
                    <div class="flexbox">
                        <div class="b-left"><a href="#index" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>

                        <form>
                            <input hidden name="route" value="settings/modules/edit">
                            <input hidden name="backstart" value="<?php echo \eMarket\Core\Pages::$start ?>">
                            <input hidden name="backfinish" value="<?php echo \eMarket\Core\Pages::$finish ?>">
                            <input hidden name="type" value="<?php echo \eMarket\Core\Valid::inGET('type') ?>">
                            <input hidden name="name" value="<?php echo \eMarket\Core\Valid::inGET('name') ?>">
                            <div class="b-left">
                                <?php if (\eMarket\Core\Pages::$start > 0) { ?>
                                    <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button>
                                <?php } else { ?>
                                    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                <?php } ?>
                            </div>
                        </form>

                        <form>
                            <input hidden name="route" value="settings/modules/edit">
                            <input hidden name="start" value="<?php echo \eMarket\Core\Pages::$start ?>">
                            <input hidden name="finish" value="<?php echo \eMarket\Core\Pages::$finish ?>">
                            <input hidden name="type" value="<?php echo \eMarket\Core\Valid::inGET('type') ?>">
                            <input hidden name="name" value="<?php echo \eMarket\Core\Valid::inGET('name') ?>">
                            <div>
                                <?php if (eMarket\Core\Pages::$finish != \eMarket\Core\Pages::$count) { ?>
                                    <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button>
                                <?php } else { ?>
                                    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-right"></span></a>
                                <?php } ?>
                            </div>
                        </form>

                    </div>
                </th>
            </tr>
            <?php if (\eMarket\Core\Pages::$count > 0) { ?>
                <tr class="border">
                    <th><?php echo lang('modules_shipping_free_admin_shipping_zone') ?></th>
                    <th class="text-center"><?php echo lang('modules_shipping_free_admin_minimum_order_price') ?></th>
                    <th></th>
                </tr>
            <?php } ?>
        </thead>
        <tbody>
            <?php
            for (\eMarket\Core\Pages::$start; \eMarket\Core\Pages::$start < \eMarket\Core\Pages::$finish; \eMarket\Core\Pages::$start++, \eMarket\Core\Pages::lineUpdate()) {
                ?>
                <tr>
                    <td><?php echo \eMarket\Core\Modules\Shipping\Free::$zones_name[eMarket\Core\Pages::$table['line']['shipping_zone']] ?></td>
                    <td class="text-center"><?php echo \eMarket\Core\Ecb::formatPrice(\eMarket\Core\Ecb::currencyPrice(eMarket\Core\Pages::$table['line']['minimum_price'], eMarket\Core\Pages::$table['line']['currency']), 1) ?></td>
                    <td>
                        <div class="flexbox">

                            <div class="b-left">
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#index" data-edit="<?php echo eMarket\Core\Pages::$table['line']['id'] ?>"><span class="glyphicon glyphicon-edit"></span></button>
                            </div>
                            <form id="form_delete<?php echo eMarket\Core\Pages::$table['line']['id'] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo eMarket\Core\Pages::$table['line']['id'] ?>')" enctype="multipart/form-data">
                                <input hidden name="delete" value="<?php echo eMarket\Core\Pages::$table['line']['id'] ?>">
                                <div>
                                    <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
                                </div>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>