<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<h1><?php echo $products['name'] ?></h1>

<div id="products" class="contentText">
    <div class="row">
        <div class="list-group-item">
            <div class="col-xs-4"><img src="/uploads/images/products/resize_2/<?php echo $products['logo_general'] ?>" alt="<?php echo $products['name'] ?>" class="img-responsive"></div>
            <div class="col-xs-8"> </div>
            <div class="clearfix"></div>
            <div class="row button">
                <div class="col-xs-6"><?php echo \eMarket\Ecb::priceInterface($products, $CURRENCIES, 1) ?></div>
                <div class="col-xs-6 text-right">
                    <?php if (\eMarket\Cart::productQuantity($products['id']) > 0) { ?>
                        <form id="quantity_product" name="quantity_product" action="javascript:void(null);" onsubmit="quantityProduct(<?php echo $products['id'] ?>, $('#number_<?php echo $products['id'] ?>').val())">
                        <?php } else { ?>
                            <form id="quantity_product" name="quantity_product" action="javascript:void(null);" onsubmit="addToCart(<?php echo $products['id'] ?>, $('#number_<?php echo $products['id'] ?>').val())">
                            <?php } ?>
                            <button class="btn btn-primary" type="button" onclick="pcsProduct('minus', <?php echo $products['id'] ?>)"><span class="glyphicon glyphicon-minus"></span></button>
                            <?php if (\eMarket\Cart::productQuantity($products['id']) > 0) { ?>
                                <input id="number_<?php echo $products['id'] ?>" type="number" min="1" value="<?php echo \eMarket\Cart::productQuantity($products['id']) ?>" class="quantity">
                            <?php } else { ?>
                                <input id="number_<?php echo $products['id'] ?>" type="number" min="1" value="1" class="quantity">
                            <?php } ?>
                            <button class="btn btn-primary" type="button" onclick="pcsProduct('plus', <?php echo $products['id'] ?>)"><span class="glyphicon glyphicon-plus"></span></button>
                            <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span> <?php echo lang('add_to_cart') ?></button>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="list-group-item">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#panel_add_1"><?php echo lang('description_product') ?></a></li>
            </ul>
            <div class="tab-content">
                <div id="panel_add_1" class="tab-pane fade in active">
                    <div class="item-text"><?php echo $products['description'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach (\eMarket\View::layoutRouting('content') as $path) {
    require_once (ROOT . $path);
}
?>