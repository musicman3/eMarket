<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Authorize,
    Settings
};
use eMarket\Catalog\Cart;
?>

<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2 px-3">
                <h3 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h3>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <form id="form_cart" name="form_cart" action="?route=checkout" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo Authorize::csrfToken() ?>" />
                    <input type="hidden" name="add" value="ok" />
                    <input type="hidden" id="products_order" name="products_order" value='<?php echo Cart::$products_order ?>' />
                    <input type="hidden" id="order_total_with_shipping" name="order_total_with_shipping" value="" />
                    <input type="hidden" id="order_shipping_price" name="order_shipping_price" value="" />
                    <input type="hidden" id="order_total" name="order_total" value="" />
                    <input type="hidden" id="order_to_pay" name="order_to_pay" value="" />
                    <input type="hidden" id="order_total_tax" name="order_total_tax" value="" />
                    <input type="hidden" id="callback_url" name="callback_url" value="" />
                    <input type="hidden" id="callback_type" name="callback_type" value="" />
                    <input type="hidden" id="callback_data" name="callback_data" value="" />
                    <input type="hidden" id="hash" name="hash" value="" />

                    <div class="mb-1">
                        <label for="address"><?php echo lang('cart_shipping_address') ?></label>
                        <div id="address_class" class="input-group input-group-sm">
                            <span class="input-group-text bi-house"></span>
                            <select name="address" id="address" class="form-control is-valid">
                                <?php
                                $x = 1;
                                foreach (Cart::$address_data as $val) {
                                    ?>
                                    <option <?php echo $val['selected'] ?>value="<?php echo $x ?>" data-regions="<?php echo $val['regions_id'] ?>"><?php echo $val['zip'] . ', ' . $val['countries_name'] . ', ' . $val['regions_name'] . ', ' . $val['city'] . ', ' . $val['address'] ?></option>
                                    <?php
                                    $x++;
                                }
                                ?>
                            </select>
                        </div>
                        <small class="form-text text-muted"><?php echo lang('cart_shipping_address_small') ?></small>
                    </div>

                    <div class="mb-1">
                        <label for="shipping_method"><?php echo lang('cart_shipping_method') ?></label>
                        <div id="shipping_method_class" class="input-group input-group-sm">
                            <span class="input-group-text bi-box-seam"></span>
                            <select name="shipping_method" id="shipping_method" class="form-control is-valid">
                                <option value="" data-shipping=""></option>
                            </select>
                        </div>
                        <small class="form-text text-muted"><?php echo lang('cart_shipping_method_small') ?></small>
                    </div>

                    <div class="mb-1">
                        <label for="payment_method"><?php echo lang('cart_payment_method') ?></label>
                        <div id="payment_method_class" class="input-group input-group-sm">
                            <span class="input-group-text bi-credit-card"></span>
                            <select name="payment_method" id="payment_method" class="form-control is-valid">
                                <option value=""></option>
                            </select>
                        </div>
                        <small class="form-text text-muted"><?php echo lang('cart_payment_method_small') ?></small>
                    </div>

                    <div id="total_price_modal" class="mb-1 text-end"></div>
                    <div id="total_tax_price" class="mb-1 text-end"></div>
                    <div id="shipping_price" class="mb-1 text-end"></div>
                    <div class="text-end">
			<span id="total_price_to_pay_modal" class="badge bg-danger"></span>
                    </div>

                </div> 
                <div class="modal-footer">
                    <button id="complete" type="button" onclick="Cart.callSuccess()" class="btn btn-primary btn-sm bi-check"> <?php echo lang('cart_сheckout') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>