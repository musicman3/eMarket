<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<form id="form_save_mod" name="form_save_mod" action="javascript:void(null);" onsubmit="callSaveMod('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>')">

    <input type="hidden" name="save" value="ok" />

    <div class="form-group">
        <label for="shipping_method">Модуль доставки</label>
        <div class="input-group">
            <select id="shipping_method" name="multiselect[]" multiple="multiple">
                <?php foreach ($shipping_method as $val) { ?>
                    <option value="<?php echo $val['name'] ?>"><?php echo lang('modules_shipping_' . $val['name'] . '_name') ?></option>
                <?php } ?>
            </select>
        </div>
        <small id="shipping_method_action" class="form-text text-muted">Выберите модуль доставки</small>
    </div>
    <div class="form-group">
        <label for="order_status">Статус заказа</label>
        <div class="input-group has-success">
            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
            <select name="order_status" id="order_status" class="input-sm form-control">
                <?php
                foreach ($order_status as $val) {
                    if ($val['default_order_status'] == 1) {
                        $selected = 'selected ';
                    } else {
                        $selected = '';
                    }
                    ?>
                    <option <?php echo $selected ?>value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <small id="order_status_action" class="form-text text-muted">Выберите статус заказа</small>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
    </div>

</form>

