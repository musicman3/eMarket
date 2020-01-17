<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach (\eMarket\View::layoutRouting('content') as $path) {
    require_once (ROOT . $path);
}
?>

<!-- Модальное окно "Добавить" -->
<?php require_once('modal/cart.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить" -->

<h1><?php echo lang('shopping_cart') ?></h1>
<?php if ($cart_info == true) { ?>
    <div id="cart" class="contentText">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="text-center"> </td>
                        <td class="text-center"><strong><?php echo lang('cart_product') ?></strong></td>
                        <td class="text-center"><strong><?php echo lang('cart_price') ?></strong></td>
                        <td class="text-center"><strong><?php echo lang('cart_quantity') ?></strong></td>
                        <td class="text-center"><strong><?php echo lang('cart_amount') ?></strong></td>
                    </tr>
                    <?php foreach ($cart_info as $value) { ?>
                        <tr>
                            <td class="text-center"><a href="/?route=products&id=<?php echo $value['id'] ?>"><img src="/uploads/images/products/resize_0/<?php echo $value['logo_general'] ?>" alt="<?php echo $value['name'] ?>" class="img-thumbnail"></a></td>
                            <td class="text-center"><a href="/?route=products&id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></td>
                            <td class="text-center"><?php echo \eMarket\Ecb::priceInterface($value, 1) ?></td>
                            <td class="text-center">
                                <form id="quantity_product" name="quantity_product" action="javascript:void(null);" onsubmit="quantityProduct(<?php echo $value['id'] ?>, $('#number_<?php echo $value['id'] ?>').val())">
                                    <button class="btn btn-primary btn-sm" type="button" onclick="pcsProduct('minus', <?php echo $value['id'] ?>)"><span class="glyphicon glyphicon-minus"></span></button>
                                    <input id="number_<?php echo $value['id'] ?>" type="number" min="1" value="<?php echo \eMarket\Cart::productQuantity($value['id']) ?>" class="quantity">
                                    <button class="btn btn-primary btn-sm" type="button" onclick="pcsProduct('plus', <?php echo $value['id'] ?>)"><span class="glyphicon glyphicon-plus"></span></button>
                                    <button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-refresh"></span></button>
                                    <button class="btn btn-primary btn-sm" type="button" onclick="deleteProduct(<?php echo $value['id'] ?>)"><span class="glyphicon glyphicon-trash"></span></button>
                                </form>
                            </td>
                            <td class="text-center"><?php echo \eMarket\Ecb::priceCartInterface($value, 1) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-sm-4 col-sm-offset-8">
		<div class="input-group">
		    <input type="text" class="form-control" id="input-coupon" placeholder="<?php echo lang('cart_discount_card_number') ?>" value="" name="discount_card">
		    <span class="input-group-btn">
			<input type="button" class="btn btn-primary" data-loading-text="Loading..." id="button-discount-card" value="<?php echo lang('cart_discount_card_apply') ?>">
		    </span>
		</div><br/>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-right"><strong><?php echo lang('cart_total') ?>:</strong></td>
                            <td class="text-right"><?php echo \eMarket\Ecb::totalPriceCartInterface(1) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="input-group-btn button">
            <div class="pull-right">
                <?php if (isset($_SESSION['email_customer']) && $address_data_json != FALSE) { ?>
                    <button type="button" class="btn btn btn-primary" data-toggle="modal" data-target="#cart"><span class="glyphicon glyphicon-share-alt"></span> <?php echo lang('cart_сheckout') ?></button>
                <?php } elseif (isset($_SESSION['email_customer']) && $address_data_json == FALSE) { ?>
                    <button type="button" class="btn btn btn-primary" onClick='location.href = "/?route=address_book&redirect=cart"'><span class="glyphicon glyphicon-share-alt"></span> <?php echo lang('cart_сheckout') ?></button>
                <?php } else { ?>
                    <button type="button" class="btn btn btn-primary" onClick='location.href = "/?route=login&redirect=cart"'><span class="glyphicon glyphicon-share-alt"></span> <?php echo lang('cart_сheckout') ?></button>
                <?php } ?>
            </div>
        </div>
    </div>  
<?php } else { ?>
    <div id="cart" class="contentText">
        <div class="well well-sm">
            <div class="btn-group">
                <div class="btn"><?php echo lang('cart_shopping_cart_empty') ?></div>
            </div>
        </div>
    </div>
<?php } ?>