<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Ecb,
    Valid
};
?>

<div id="checkout" class="contentText">
    <div><?php echo lang('modules_payment_cash_catalog_text') ?>
        <br><br>
        <span id="total_price_to_pay_modal" class="badge bg-success"><?php echo lang('modules_payment_cash_catalog_amount_to_pay') ?> <?php echo Ecb::formatPrice(Valid::inPOST('order_to_pay'), 1) ?></span>
        <br><br>
    </div>


    <div class="float-none">
        <button id="complete" type="button" onclick="Checkout.callSuccess()" class="btn btn-primary btn-sm bi-check"> <?php echo lang('modules_payment_cash_catalog_complete_button') ?></button>
    </div>
</div>

