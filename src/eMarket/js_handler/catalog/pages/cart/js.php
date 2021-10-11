<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Ecb,
    Interfaces,
};

$INTERFACE = new Interfaces();
Ecb::priceTerminal();
$lang_js = json_encode([
    'cart_payment_is_not_available' => lang('cart_payment_is_not_available'),
    'cart_shipping_is_not_available' => lang('cart_shipping_is_not_available'),
    'cart_shipping_price' => lang('cart_shipping_price'),
    'product_price' => Ecb::formatPrice(0, 1),
    'total_price_cart_with_sale' => Ecb::formatPrice($INTERFACE->load('priceTerminal', 'data', 'discounted_price'), 1),
    'cart_subtotal' => lang('cart_subtotal'),
    'cart_total' => lang('cart_total'),
    'cart_estimated_taxes' => lang('cart_estimated_taxes'),
    'cart_price_including_all_taxes' => lang('cart_price_including_all_taxes'),
    'cart_shipping_is_not_available_and_min_price' => lang('cart_shipping_is_not_available_and_min_price')
        ]);
?>
<script type="text/javascript" src="/js_handler/catalog/pages/cart/main.js"></script>
<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    sessionStorage.setItem('lang', '<?php echo $lang_js ?>');
    new Cart();
    new Ajax();
</script>
