<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\Modules\Payment\Cash;
?>

<form id="form_add_mod" name="form_add_mod" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_add_mod')">

    <input type="hidden" name="save" value="ok" />

    <div class="form-group">
        <label for="shipping_method"><?php echo lang('modules_payment_cash_admin_shipping_method') ?></label>
        <div class="input-group">
            <select id="shipping_method" name="multiselect[]" multiple="multiple">
                <?php
                foreach (Cash::$shipping_method as $val) {
                    if (is_array(Cash::$shipping_val) && in_array($val['name'], Cash::$shipping_val)) {
                        $selected_shipping = 'selected ';
                    } else {
                        $selected_shipping = '';
                    }
                    ?>
                    <option <?php echo $selected_shipping ?>value="<?php echo $val['name'] ?>"><?php echo lang('modules_shipping_' . $val['name'] . '_name') ?></option>
                <?php } ?>
            </select>
        </div>
        <small id="shipping_method_action" class="form-text text-muted"><?php echo lang('modules_payment_cash_admin_shipping_method_select') ?></small>
    </div>
    <div class="form-group">
        <label for="order_status"><?php echo lang('modules_payment_cash_admin_order_status') ?></label>
        <div class="input-group has-success">
            <span class="input-group-addon"><span class="bi-pencil"></span></span>
            <select name="order_status" id="order_status" class="input-sm form-control">
                <?php
                foreach (Cash::$order_status as $val) {
                    if ($val['id'] == Cash::$order_status_selected) {
                        $selected = 'selected ';
                    } else {
                        $selected = '';
                    }
                    ?>
                    <option <?php echo $selected ?>value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <small id="order_status_action" class="form-text text-muted"><?php echo lang('modules_payment_cash_admin_order_status_select') ?></small>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary"><span class="bi-check-circle"></span> <?php echo lang('save') ?></button>
    </div>

</form>

