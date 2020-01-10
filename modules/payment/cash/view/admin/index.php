<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<form id="form_save_mod" name="form_save_mod" action="javascript:void(null);" onsubmit="callSaveMod()">

        <input type="hidden" name="add" value="ok" />

            <div class="form-group">
                <label for="shipping_method">Модуль доставки</label>
                <div class="input-group">
                    <select id="shipping_method" name="multiselect[]" multiple="multiple">
                        <option value="free">Бесплатная доставка</option>
                        <option value="free_2">Самовывоз</option>
                    </select>
                </div>
                <small id="shipping_method_action" class="form-text text-muted">Выберите модуль доставки</small>
            </div>
            <div class="form-group">
                <label for="order_status">Статус заказа</label>
                <div class="input-group has-success">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                    <select name="order_status" id="order_status" class="input-sm form-control">
                        <option value="pending">Ожидает оплаты</option>
                        <option value="payment">Оплачено</option>
                    </select>
                </div>
                <small id="order_status_action" class="form-text text-muted">Выберите статус заказа</small>
            </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
    </div>

</form>

