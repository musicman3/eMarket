<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Settings
};
use eMarket\Core\Modules\Shipping\Free;
?>

<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form_add_mod" class="was-validated" name="form_add_mod" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_add_mod')">
                <div class="modal-body">
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />

                    <div class="tab-content pt-2">
                        <div class="mb-2">
                            <small class="form-text text-muted" for="zone"><?php echo lang('modules_shipping_free_admin_shipping_zone') ?></small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bi-pencil"></span>
                                <select name="zone" id="zone" class="form-select">
                                    <?php
                                    foreach (Free::$zones as $val) {
                                        ?>
                                        <option value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            
                        </div>
                        <div class="mb-2">
                            <small class="form-text text-muted" for="zone"><?php echo lang('modules_shipping_free_admin_minimum_order_price') ?></small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><?php echo Settings::currencyDefault()[3] ?></span>
                                <input class="form-control" placeholder="<?php echo lang('modules_shipping_free_admin_minimum_order_price_for_free_shipping') ?>" type="text" name="minimum_price" id="minimum_price" autocomplete="off" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm bi-x-circle" type="button" data-bs-dismiss="modal"> <?php echo lang('cancel') ?></button>
                    <button class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>