<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Authorize,
    Messages,
    View,
    Valid
};

foreach (View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
?>

<form id="form_cart" name="form_cart" action="javascript:void(null);">
    <input type="hidden" name="csrf_token" value="<?php echo Authorize::csrfToken() ?>" />
    <input type="hidden" name="add" value="ok" />
    <input type="hidden" id="products_order" name="products_order" value='<?php echo Valid::inPOST('products_order') ?>' />
    <input type="hidden" id="order_total_with_shipping" name="order_total_with_shipping" value="<?php echo Valid::inPOST('order_total_with_shipping') ?>" />
    <input type="hidden" id="order_shipping_price" name="order_shipping_price" value="<?php echo Valid::inPOST('order_shipping_price') ?>" />
    <input type="hidden" id="order_total" name="order_total" value="<?php echo Valid::inPOST('order_total') ?>" />
    <input type="hidden" id="order_to_pay" name="order_to_pay" value="<?php echo Valid::inPOST('order_to_pay') ?>" />
    <input type="hidden" id="order_total_tax" name="order_total_tax" value="<?php echo Valid::inPOST('order_total_tax') ?>" />
    <input type="hidden" id="callback_url" name="callback_url" value="<?php echo Valid::inPOST('callback_url') ?>" />
    <input type="hidden" id="callback_type" name="callback_type" value="<?php echo Valid::inPOST('callback_type') ?>" />
    <input type="hidden" id="callback_data" name="callback_data" value='<?php echo Valid::inPOST('callback_data') ?>' />
    <input type="hidden" id="hash" name="hash" value="<?php echo Valid::inPOST('hash') ?>" />
    <input type="hidden" id="address" name="address" value="<?php echo Valid::inPOST('address') ?>" />
    <input type="hidden" id="shipping_method" name="shipping_method" value="<?php echo Valid::inPOST('shipping_method') ?>" />
    <input type="hidden" id="payment_method" name="payment_method" value="<?php echo Valid::inPOST('payment_method') ?>" />
</form>

<div id="alert_block"><?php Messages::alert(); ?></div>
<h1><?php echo lang('checkout_text') ?></h1>

<?php require_once (ROOT . '/modules/payment/' . Valid::inPOST('payment_method') . '/controller/catalog/index.php');