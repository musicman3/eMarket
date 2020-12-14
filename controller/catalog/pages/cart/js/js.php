<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
$lang_js = json_encode([
    'cart_payment_is_not_available' => lang('cart_payment_is_not_available'),
    'cart_shipping_is_not_available' => lang('cart_shipping_is_not_available'),
    'cart_shipping_price' => lang('cart_shipping_price'),
    'product_price' => \eMarket\Ecb::formatPrice(0, 1),
    'total_price_cart_with_sale' => \eMarket\Ecb::formatPrice(\eMarket\Ecb::priceTerminal(), 1),
    'cart_total_to_pay' => lang('cart_total_to_pay'),
    'cart_shipping_is_not_available_and_min_price' => lang('cart_shipping_is_not_available_and_min_price')
        ]);
?>
<script type="text/javascript" src="/model/js/classes/cart/cart.js"></script>
<script type="text/javascript">
    sessionStorage.setItem('lang', '<?php echo $lang_js ?>');
    new Cart();
</script>