<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div class="form-group">
    <div class="input-group has-success">
        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
        <select name="module_zones" id="module_zones" class="input-sm form-control">
            <option value="no"><?php echo lang('modules_payment_cash_admin_select_no') ?></option>
            <?php foreach ($zones as $value) { ?>
            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="form-group">
    <div class="input-group has-error">
        <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
        <input class="input-sm form-control" placeholder="<?php echo lang('value') ?>" type="text" name="value_length" id="value_length" />
    </div>
</div>
