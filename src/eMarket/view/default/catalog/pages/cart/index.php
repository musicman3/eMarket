<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Ecb,
    Routing
};
use eMarket\Catalog\{
    Cart
};

foreach (Routing::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
require_once('modal/index.php')
?>

<h1><?php echo lang('shopping_cart') ?></h1>
<?php if (Cart::$cart_info == true) { ?>
    <div id="cart" class="contentText">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr class="border-top border-end border-start align-middle">
                        <td class="text-center"> </td>
                        <td class="text-center"><strong><?php echo lang('cart_product') ?></strong></td>
                        <td class="text-center"><strong><?php echo lang('cart_price') ?></strong></td>
                        <td class="text-center"><strong><?php echo lang('cart_quantity') ?></strong></td>
                        <td class="text-center"><strong><?php echo lang('cart_amount') ?></strong></td>
                    </tr>
                    <?php foreach (Cart::$cart_info as $value) { ?>
                        <tr class="border-end border-start align-middle">
                            <td class="text-center"><a href="/?route=products&id=<?php echo $value['id'] ?>"><img src="/uploads/images/products/resize_0/<?php echo $value['logo_general'] ?>" alt="<?php echo $value['name'] ?>" class="img-thumbnail mx-auto d-block"></a></td>
                            <td class="text-center"><a href="/?route=products&id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></td>
                            <td class="text-center"><?php echo Ecb::priceInterface($value, 1) ?></td>
                            <td class="text-center text-nowrap">
                                <form id="quantity_product" name="quantity_product" action="javascript:void(null);">
                                    <button class="btn btn-primary btn-sm bi-dash" type="button" onclick="Cart.pcsProduct('minus', <?php echo $value['id'] ?>); Cart.quantityProduct(<?php echo $value['id'] ?>, document.querySelector('#number_<?php echo $value['id'] ?>').value)"></button>
                                    <input id="number_<?php echo $value['id'] ?>" data-bs-placement="top" data-bs-content="<?php echo lang('listing_no_more_in_stock') ?>" type="number" min="1" value="<?php echo Cart::productQuantity($value['id']) ?>" class="quantity" disabled>
                                    <button class="btn btn-primary btn-sm button-plus bi-plus" type="button" onclick="Cart.pcsProduct('plus', <?php echo $value['id'] ?>, <?php echo $value['quantity'] ?>); Cart.quantityProduct(<?php echo $value['id'] ?>, document.querySelector('#number_<?php echo $value['id'] ?>').value)"></button>
                                    <button class="btn btn-primary btn-sm bi-trash" type="button" onclick="Cart.deleteProduct(<?php echo $value['id'] ?>)"></button>
                                </form>
                            </td>
                            <td class="text-center"><?php echo Ecb::priceInterface($value, 1, Cart::productQuantity($value['id'], 1)) ?></td>
                        </tr>
                    <?php } ?>
                    <tr class="border-end border-start border-bottom align-middle">
                        <td colspan="5"> </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end">
            <div class="col-auto">
                <table class="table">
                    <tbody>
                        <tr class="border align-middle">
                            <td class="text-end"><strong><?php echo lang('cart_subtotal') ?></strong></td>
                            <td class="text-end"><?php echo Ecb::totalPriceCartInterface(1) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="float-end">
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
<?php } else { ?>
    <div id="cart" class="contentText">
        <div class="bg-light border rounded mb-3 py-3 px-2">
            <p class="card-text"><?php echo lang('cart_shopping_cart_empty') ?></p>
        </div>
    </div>
    <?php
}
