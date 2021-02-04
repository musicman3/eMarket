<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Ecb,
    View
};
use \eMarket\Catalog\Cart;

foreach (View::tlpc('content') as $path) {
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
                    <tr class="trtop align-middle">
                        <td class="text-center"> </td>
                        <td class="text-center"><strong><?php echo lang('cart_product') ?></strong></td>
                        <td class="text-center"><strong><?php echo lang('cart_price') ?></strong></td>
                        <td class="text-center"><strong><?php echo lang('cart_quantity') ?></strong></td>
                        <td class="text-center"><strong><?php echo lang('cart_amount') ?></strong></td>
                    </tr>
                    <?php foreach (Cart::$cart_info as $value) { ?>
                        <tr class="trbottom align-middle">
                            <td class="text-center"><a href="/?route=products&category_id=<?php echo $value['parent_id'] ?>&id=<?php echo $value['id'] ?>"><img src="/uploads/images/products/resize_0/<?php echo $value['logo_general'] ?>" alt="<?php echo $value['name'] ?>" class="img-thumbnail mx-auto d-block"></a></td>
                            <td class="text-center"><a href="/?route=products&category_id=<?php echo $value['parent_id'] ?>&id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></td>
                            <td class="text-center"><?php echo Ecb::priceInterface($value, 1) ?></td>
                            <td nowrap class="text-center">
                                <form id="quantity_product" name="quantity_product" action="javascript:void(null);" onsubmit="Cart.quantityProduct(<?php echo $value['id'] ?>, $('#number_<?php echo $value['id'] ?>').val())">
                                    <button class="btn btn-primary btn-sm" type="button" onclick="Cart.pcsProduct('minus', <?php echo $value['id'] ?>)"><span class="bi-dash"></span></button>
                                    <input id="number_<?php echo $value['id'] ?>" data-placement="top" data-content="<?php echo lang('listing_no_more_in_stock') ?>" type="number" min="1" value="<?php echo \eMarket\Core\Cart::productQuantity($value['id']) ?>" class="quantity">
                                    <button class="btn btn-primary btn-sm button-plus" type="button" onclick="Cart.pcsProduct('plus', <?php echo $value['id'] ?>, <?php echo $value['quantity'] ?>)"><span class="bi-plus"></span></button>
                                    <button class="btn btn-primary btn-sm" type="submit"><span class="bi-arrow-repeat"></span></button>
                                    <button class="btn btn-primary btn-sm" type="button" onclick="Cart.deleteProduct(<?php echo $value['id'] ?>)"><span class="bi-trash"></span></button>
                                </form>
                            </td>
                            <td class="text-center"><?php echo Ecb::priceInterface($value, 1, \eMarket\Core\Cart::productQuantity($value['id'], 1)) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end">
            <div class="col-auto">
                <table class="table">
                    <tbody>
                        <tr class="trcenter align-middle">
                            <td class="text-end"><strong><?php echo lang('cart_subtotal') ?></strong></td>
                            <td class="text-end"><?php echo Ecb::totalPriceCartInterface(1) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="float-end">
            <?php if (isset($_SESSION['email_customer']) && Cart::$address_data_json != FALSE) { ?>
                <button type="button" class="btn btn btn-primary" data-bs-toggle="modal" data-bs-target="#index"><?php echo lang('cart_сheckout') ?></button>
            <?php } elseif (isset($_SESSION['email_customer']) && Cart::$address_data_json == FALSE) { ?>
                <button type="button" class="btn btn btn-primary" onClick='location.href = "/?route=address_book&redirect=cart"'><?php echo lang('cart_сheckout') ?></button>
            <?php } else { ?>
                <button type="button" class="btn btn btn-primary" onClick='location.href = "/?route=login&redirect=cart"'><?php echo lang('cart_сheckout') ?></button>
            <?php } ?>
        </div>
    </div>  
<?php } else { ?>
    <div id="cart" class="contentText">
        <div class="card bg-light">
            <div class="card-body">
                <p class="card-text"><?php echo lang('cart_shopping_cart_empty') ?></p>
            </div>
        </div>
    </div>
<?php }