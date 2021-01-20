<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Cart,
    Ecb,
    Products as ProductsCore,
    View
};
use \eMarket\Catalog\Products;

if (Products::$products != FALSE) {
    require_once('modal/cart_message.php')
    ?>

    <h1><?php echo Products::$products['name'] ?></h1>

    <div id="products" class="contentText">
        <div class="row">
            <div class="col-sm-6 col-xs-12">

                <div class="labelsblock">
                    <?php foreach (ProductsCore::stikers(Products::$products, 'label-danger', 'label-success') as $stiker) { ?>
                        <div class="<?php echo $stiker[0] ?>"><?php echo $stiker[1] ?></div>
                    <?php } ?>
                </div>

                <a href="/uploads/images/products/resize_4/<?php echo Products::$products['logo_general'] ?>" data-toggle="lightbox" data-gallery="example-gallery" data-type="image">
                    <img src="/uploads/images/products/resize_2/<?php echo Products::$products['logo_general'] ?>" alt="<?php echo Products::$products['name'] ?>" class="img-padding img-responsive center-block">
                </a>
                <div class="row">
                    <?php foreach (Products::$images as $val) { ?>
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <a href="/uploads/images/products/resize_4/<?php echo $val ?>" data-toggle="lightbox" data-gallery="example-gallery" data-type="image" class="thumbnail">
                                <img src="/uploads/images/products/resize_1/<?php echo $val ?>" alt="<?php echo Products::$products['name'] ?>">
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 productpage">
                <ul>
                    <li>
                        <span class="productpage-price"><?php echo Ecb::priceInterface(Products::$products, 2) ?></span>
                    </li>
                </ul>
                <hr>
                <ul>
                    <?php if (Products::$vendor_code_value != NULL && Products::$vendor_code_value != '') { ?>
                        <li>
                            <label><?php echo Products::$vendor_code ?>:</label>
                            <span> <?php echo Products::$vendor_code_value ?></span>
                        </li>
                    <?php } if (Products::$manufacturer != NULL && Products::$manufacturer != FALSE) { ?>
                        <li>
                            <label><?php echo lang('product_manufacturer') ?></label>
                            <span> <?php echo Products::$manufacturer ?></span>
                        </li>
                    <?php } if (Products::$products['model'] != NULL && Products::$products['model'] != FALSE) { ?>
                        <li>
                            <label><?php echo lang('product_model') ?></label>
                            <span> <?php echo Products::$products['model'] ?></span>
                        </li>
                    <?php } if (Products::$weight_value != NULL && Products::$weight_value != '') { ?>
                        <li>
                            <label><?php echo lang('product_weight') ?></label>
                            <span> <?php echo Products::$weight_value . ' ' . Products::$weight ?> </span>
                        </li>
                    <?php } if (Products::$dimensions != '') { ?>
                        <li>
                            <label><?php echo sprintf(lang('product_dimension'), Products::$dimension_name) ?></label>
                            <span> <?php echo Products::$dimensions ?></span>
                        </li>
                    <?php } ?>
                    <li>
                        <label><?php echo lang('product_availability') ?></label>
                        <?php echo \eMarket\Core\Products::inStock(Products::$products['date_available'], Products::$products['quantity']); ?>
                    </li>
                </ul>
                <hr>
                <div>
                    <button class="btn btn-primary" type="button" onclick="Products.pcsProduct('minus', <?php echo Products::$products['id'] ?>, <?php echo Products::$products['quantity'] ?>)"><span class="glyphicon glyphicon-minus"></span></button>
                    <input id="number_<?php echo Products::$products['id'] ?>" data-placement="top" data-content="<?php echo lang('listing_no_more_in_stock') ?>" type="number" min="1" value="<?php echo Cart::maxQuantityToOrder(Products::$products) ?>" class="quantity" disabled>
                    <button class="btn btn-primary button-plus" type="button" onclick="Products.pcsProduct('plus', <?php echo Products::$products['id'] ?>, <?php echo Cart::maxQuantityToOrder(Products::$products, 'true') ?>)"><span class="glyphicon glyphicon-plus"></span></button>
                    <button class="btn btn-primary plus<?php echo Cart::maxQuantityToOrder(Products::$products, 'class') ?>" onclick="Products.addToCart(<?php echo Products::$products['id'] ?>, $('#number_<?php echo Products::$products['id'] ?>').val())"><?php echo lang('add_to_cart') ?></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="list-group-item">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#panel_description"><?php echo lang('product_description') ?></a></li>
                    <li><a data-toggle="tab" href="#panel_attribute"><?php echo lang('product_specification') ?></a></li>
                </ul>
                <div class="tab-content">
                    <div id="panel_description" class="tab-pane fade in active">
                        <div class="item-text"><?php echo Products::$products['description'] ?></div>
                    </div>

                    <input id="selected_attributes" type="hidden" name="selected_attributes" value="" />
                    <div id="panel_attribute" class="tab-pane fade">
                        <div class="item-text product-attribute"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php } else {
    ?>
    <h1><?php echo lang('product_not_found') ?></h1>

    <div id="products" class="contentText">
        <div class="well well-sm">
            <div class="no">
                <?php echo lang('product_not_found_message') ?>
            </div>
        </div>
    </div>
    <?php
}

foreach (View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}