<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\Ecb;
use eMarket\Catalog\{
    Cart
};
use eMarket\Admin\Templates;

foreach (Templates::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
require_once('modal/index.php')
?>

<h1><?php echo lang('shopping_cart') ?></h1>
<?php if (Cart::$cart_info == true) { ?>
    <div id="cart" class="contentText">

        <div class="card border rounded p-3">

            <?php foreach (Cart::$cart_info as $value) { ?>
                <form id="quantity_product" name="quantity_product" action="javascript:void(null);">
                    <div class="d-flex align-items-center border-bottom p-1">
                        <div class="text-center">
                            <div class="p-1">
                                <div><a href="/?route=products&id=<?php echo $value['id'] ?>"><img src="/uploads/images/products/resize_0/<?php echo $value['logo_general'] ?>" alt="<?php echo $value['name'] ?>" class="img-thumbnail"></a></div>
                                <div><a href="/?route=products&id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></div>
                            </div>
                        </div>
                        <div class="p-1 ms-auto text-center w-50">
                            <h3><span class="badge text-bg-primary"><?php echo Ecb::priceInterface($value, 1, Cart::productQuantity($value['id'], 1)) ?></span></h3>
                            <div class="d-flex align-items-center">
                                <div class="text-center w-100">
                                    <button class="btn btn-outline-primary btn-sm bi-dash" type="button" onclick="Cart.pcsProduct('minus', <?php echo $value['id'] ?>); Cart.quantityProduct(<?php echo $value['id'] ?>, document.querySelector('#number_<?php echo $value['id'] ?>').value)"></button>
                                    <input id="number_<?php echo $value['id'] ?>" data-bs-placement="top" data-bs-content="<?php echo lang('listing_no_more_in_stock') ?>" type="number" min="1" value="<?php echo Cart::productQuantity($value['id']) ?>" class="quantity" disabled>
                                    <button class="btn btn-outline-primary btn-sm button-plus bi-plus" type="button" onclick="Cart.pcsProduct('plus', <?php echo $value['id'] ?>, <?php echo $value['quantity'] ?>); Cart.quantityProduct(<?php echo $value['id'] ?>, document.querySelector('#number_<?php echo $value['id'] ?>').value)"></button>
                                </div>
                            </div>
                        </div>
                        <div class="p-1 ms-auto text-end"><button class="btn btn-primary btn-sm bi-trash" type="button" onclick="Cart.deleteProduct(<?php echo $value['id'] ?>)"></button></div>
                    </div>
                </form>
            <?php } ?>
        </div>

        <div class="d-flex flex-row-reverse">
            <div class="mt-3">
                <div class="card border rounded p-2 h-100 d-flex flex-row">
                    <div class="p-1"><strong><?php echo lang('cart_subtotal') ?></div>
                    <div class="p-1"><h3><span class="badge text-bg-success"><?php echo Ecb::totalPriceCartInterface(1) ?></span></h3></div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-row-reverse">
            <div class="mt-3">
                <?php if (isset($_SESSION['customer_email']) && Cart::$address_data_json != FALSE) { ?>
                    <button type="button" class="btn btn btn-success" data-bs-toggle="modal" data-bs-target="#index"><?php echo lang('cart_validate_purchase') ?></button>
                <?php } elseif (Cart::$address_data_json != FALSE && isset($_SESSION['without_registration_data'])) { ?>
                    <button type="button" class="btn btn btn-outline-dark" onClick='location.href = "/?route=without_registration"'><?php echo lang('cart_edit_shipping_information') ?></button>
                    <button type="button" class="btn btn btn-success" data-bs-toggle="modal" data-bs-target="#index"><?php echo lang('cart_validate_purchase') ?></button>
                <?php } elseif (isset($_SESSION['customer_email']) && Cart::$address_data_json == FALSE) { ?>
                    <button type="button" class="btn btn btn-primary" onClick='location.href = "/?route=address_book&redirect=cart"'><?php echo lang('cart_сheckout') ?></button>
                <?php } else { ?>
                    <button type="button" class="btn btn btn-primary" onClick='location.href = "/?route=login&redirect=cart"'><?php echo lang('cart_сheckout') ?></button>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div id="cart" class="contentText">
        <div class="bg-light border rounded mb-3 py-3 px-2">
            <p class="card-text"><?php echo lang('cart_shopping_cart_empty') ?></p>
        </div>
    </div>
    <?php
}
