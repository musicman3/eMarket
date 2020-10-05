<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Модальное окно "Корзина" -->
<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Set::titlePageGenerator() ?></h4>
            </div>
            <form id="form_cart" name="form_cart" action="javascript:void(null);" onsubmit="callSuccess()">
                <div class="panel-body">
                    <input type="hidden" name="add" value="ok" />
                    <input type="hidden" id="products_order" name="products_order" value='<?php echo $products_order ?>' />
                    <input type="hidden" id="order_total_with_shipping" name="order_total_with_shipping" value="" />
                    <input type="hidden" id="order_shipping_price" name="order_shipping_price" value="" />
                    <input type="hidden" id="order_total" name="order_total" value="" />
                    <input type="hidden" id="callback_url" name="callback_url" value="" />
                    <input type="hidden" id="hash" name="hash" value="" />

                    <div class="form-group">
                        <label for="address"><?php echo lang('cart_shipping_address') ?></label>
                        <div id="address_class" class="input-group has-success">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <select name="address" id="address" class="input-sm form-control">
                                <?php
                                $x = 1;
                                foreach ($address_data as $val) {
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

                    <div class="form-group">
                        <label for="shipping_method"><?php echo lang('cart_shipping_method') ?></label>
                        <div id="shipping_method_class" class="input-group has-success">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <select name="shipping_method" id="shipping_method" class="input-sm form-control">
                                <option value="" data-shipping=""></option>
                            </select>
                        </div>
                        <small class="form-text text-muted"><?php echo lang('cart_shipping_method_small') ?></small>
                    </div>

                    <div class="form-group">
                        <label for="payment_method"><?php echo lang('cart_payment_method') ?></label>
                        <div id="payment_method_class" class="input-group has-success">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <select name="payment_method" id="payment_method" class="input-sm form-control">
                                <option value=""></option>
                            </select>
                        </div>
                        <small class="form-text text-muted"><?php echo lang('cart_payment_method_small') ?></small>
                    </div>

                    <div id="shipping_price" class="form-group text-right"></div>
                    <div id="total_price_modal" class="pull-right label label-danger"></div>

                </div> 
                <div class="modal-footer">
                    <button id="complete" type="submit" class="btn btn btn-primary"><span class="glyphicon glyphicon-ok"></span> <?php echo lang('cart_complete_button') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно "Корзина" -->