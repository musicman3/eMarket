<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Settings
};
use \eMarket\Core\Modules\Shipping\Free;
?>

<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h4>
            </div>
            <form id="form_add_mod" name="form_add_mod" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_add_mod')">
                <div class="panel-body">
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />

                    <div class="tab-content">
                        <div class="form-group">
                            <label for="zone"><?php echo lang('modules_shipping_free_admin_shipping_zone') ?></label>
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="bi-pencil"></span></span>
                                <select name="zone" id="zone" class="input-sm form-control">
                                    <?php
                                    foreach (Free::$zones as $val) {
                                        ?>
                                        <option value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <small id="zone_action" class="form-text text-muted"><?php echo lang('modules_shipping_free_admin_shipping_zone_select') ?></small>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><?php echo Settings::currencyDefault()[3] ?></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('modules_shipping_free_admin_minimum_order_price_for_free_shipping') ?>" type="text" name="minimum_price" id="minimum_price" autocomplete="off" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" type="button" data-dismiss="modal"><span class="bi-x-circle"></span> <?php echo lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-sm"><span class="bi-check-circle"></span> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>