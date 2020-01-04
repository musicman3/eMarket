<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

require(ROOT . '/controller/catalog/pages/cart/modal/cart.php');
?>
<!-- Модальное окно "Корзина" -->
<div id="cart" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Сокращенное наименование указывается любыми символами" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Set::titlePageGenerator() ?></h4>
            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label for="address"><?php echo lang('cart_shipping_address') ?></label>
                    <div class="input-group has-success">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                        <select name="address" id="address" class="input-sm form-control">
                            <?php
                            $x = 1;
                            foreach ($address_data as $val) {
                                ?>
                                <option <?php echo $val['selected'] ?>value="<?php echo $x ?>" data-regions="<?php echo $val['regions_id'] ?>"><?php echo $val['zip'] . ', ' . $val['countries_name'] . ', ' . $val['regions_name'] . ', ' . $val['city'] . ', ' . $val['address'] ?></option>
                                <?php $x++;
                            }
                            ?>
                        </select>
                    </div>
                    <small id="address_method" class="form-text text-muted"><?php echo lang('cart_shipping_address_small') ?></small>
                </div>

                <div class="form-group">
                    <label for="shipping_method"><?php echo lang('cart_shipping_method') ?></label>
                    <div id="shipping_method_class" class="input-group has-success">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                        <select name="shipping_method" id="shipping_method" class="input-sm form-control">
                            <option value=""></option>
                        </select>
                    </div>
                    <small id="shipping_method" class="form-text text-muted"><?php echo lang('cart_shipping_method_small') ?></small>
                </div>

                <div class="form-group">
                    <label for="payment"><?php echo lang('cart_payment_method') ?></label>
                    <div class="input-group has-success">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                        <select name="payment" id="payment" class="input-sm form-control">
                            <option value="1">Наличными в офисе</option>
                            <option value="2">VISA/MASTERCARD</option>
                        </select>
                    </div>
                    <small id="payment_method" class="form-text text-muted"><?php echo lang('cart_payment_method_small') ?></small>
                </div>

            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn btn-primary" data-toggle="modal" data-target="#cart"><span class="glyphicon glyphicon-ok"></span> <?php echo lang('cart_complete_button') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно "Корзина" -->