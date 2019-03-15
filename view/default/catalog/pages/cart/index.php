<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach ($VIEW->layoutRouting('content') as $path) {
    require_once (ROOT . $path);
}

?>

<h1>Shopping Cart</h1>
<?php if ($cart_info == true) { ?>
    <div id="cart" class="contentText">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <?php foreach ($cart_info as $value) { ?>
                        <tr>
                            <td class="text-center"><a href="/?route=products&id=<?php echo $value['id'] ?>"><img class="img-thumbnail" src="/uploads/images/products/resize_0/<?php echo $value['logo_general'] ?>"></a></td>
                            <td class="text-left"><a href="/?route=products&id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></td>
                            <td class="text-right">
                                <form id="quantity_product" name="quantity_product" action="javascript:void(null);" onsubmit="quantityProduct(<?php echo $value['id'] ?>, $('#number_<?php echo $value['id'] ?>').val())">
                                    <button class="btn btn-primary btn-sm" type="button" onclick="this.nextElementSibling.stepDown()"><span class="glyphicon glyphicon-minus"></span></button>
                                    <input id="number_<?php echo $value['id'] ?>" type="number" min="1" max="999" value="<?php echo $CART->cartProductQuantity($value['id']) ?>" readonly class="form-control quantity">
                                    <button class="btn btn-primary btn-sm" type="button" onclick="this.previousElementSibling.stepUp()"><span class="glyphicon glyphicon-plus"></span></button>
                                    <button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-refresh"></span></button>
                                </form>
                            </td>
                            <td class="text-left">
                                <form id="delete_product" name="delete_product" action="javascript:void(null);" onsubmit="deleteProduct(<?php echo $value['id'] ?>)">
                                    <button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-trash"></span></button>
                                </form>
                            </td>
                            <td class="text-right"><?php echo $PRODUCTS->productPrice($value['price'] * $CART->cartProductQuantity($value['id']), $CURRENCIES, 1) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-sm-4 col-sm-offset-8">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-right"><strong>Total:</strong></td>
                            <td class="text-right"><?php echo $PRODUCTS->productPrice($CART->totalPrice(), $CURRENCIES, 1) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="input-group-btn button">
            <div class="pull-left"><a class="btn btn-primary" href="/">Continue Shopping</a></div>
            <div class="pull-right"><a class="btn btn-primary" href="/">Checkout</a></div>
        </div>
    </div>
<?php } else { ?>
    <div id="cart" class="contentText">
        <div class="well well-sm">
            <div class="btn-group">
                <div class="btn">В корзине нет товаров.</div>
            </div>
        </div>
    </div>
<?php } ?>

<?php
$AJAX->сart('');

?>