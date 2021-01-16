<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Catalog\Products::$products != FALSE) {
    ?>

    <!-- Модальное окно -->
    <?php require_once('modal/cart_message.php') ?>
    <!-- КОНЕЦ Модальное окно -->

    <h1><?php echo \eMarket\Catalog\Products::$products['name'] ?></h1>

    <div id="products" class="contentText">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <?php echo \eMarket\Products::stikers(\eMarket\Catalog\Products::$products, 'label-danger', 'label-success') ?>
                <a href="/uploads/images/products/resize_4/<?php echo \eMarket\Catalog\Products::$products['logo_general'] ?>" data-toggle="lightbox" data-gallery="example-gallery" data-type="image">
                    <img src="/uploads/images/products/resize_2/<?php echo \eMarket\Catalog\Products::$products['logo_general'] ?>" alt="<?php echo \eMarket\Catalog\Products::$products['name'] ?>" class="img-padding img-responsive center-block">
                </a>
                <div class="row">
                    <?php foreach (\eMarket\Catalog\Products::$images as $val) { ?>
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <a href="/uploads/images/products/resize_4/<?php echo $val ?>" data-toggle="lightbox" data-gallery="example-gallery" data-type="image" class="thumbnail">
                                <img src="/uploads/images/products/resize_1/<?php echo $val ?>" alt="<?php echo \eMarket\Catalog\Products::$products['name'] ?>">
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 productpage">
                <ul>
                    <li>
                        <span class="productpage-price"><?php echo \eMarket\Ecb::priceInterface(\eMarket\Catalog\Products::$products, 1) ?></span>
                    </li>
                </ul>
                <hr>
                <ul>
                    <?php if (\eMarket\Catalog\Products::$vendor_code_value != NULL && \eMarket\Catalog\Products::$vendor_code_value != '') { ?>
                        <li>
                            <label><?php echo \eMarket\Catalog\Products::$vendor_code ?>:</label>
                            <span> <?php echo \eMarket\Catalog\Products::$vendor_code_value ?></span>
                        </li>
                    <?php } if (\eMarket\Catalog\Products::$manufacturer != NULL && \eMarket\Catalog\Products::$manufacturer != FALSE) { ?>
                        <li>
                            <label><?php echo lang('product_manufacturer') ?></label>
                            <span> <?php echo \eMarket\Catalog\Products::$manufacturer ?></span>
                        </li>
                    <?php } if (\eMarket\Catalog\Products::$products['model'] != NULL && \eMarket\Catalog\Products::$products['model'] != FALSE) { ?>
                        <li>
                            <label><?php echo lang('product_model') ?></label>
                            <span> <?php echo \eMarket\Catalog\Products::$products['model'] ?></span>
                        </li>
                    <?php } if (\eMarket\Catalog\Products::$weight_value != NULL && \eMarket\Catalog\Products::$weight_value != '') { ?>
                        <li>
                            <label><?php echo lang('product_weight') ?></label>
                            <span> <?php echo \eMarket\Catalog\Products::$weight_value . ' ' . \eMarket\Catalog\Products::$weight ?> </span>
                        </li>
                    <?php } if (\eMarket\Catalog\Products::$dimensions != '') { ?>
                        <li>
                            <label><?php echo sprintf(lang('product_dimension'), \eMarket\Catalog\Products::$dimension_name) ?></label>
                            <span> <?php echo \eMarket\Catalog\Products::$dimensions ?></span>
                        </li>
                    <?php } ?>
                    <li>
                        <label><?php echo lang('product_availability') ?></label>
                        <?php echo \eMarket\Products::inStock(\eMarket\Catalog\Products::$products['date_available'], \eMarket\Catalog\Products::$products['quantity']); ?>
                    </li>
                </ul>
                <hr>
                <div>
                    <button class="btn btn-primary" type="button" onclick="Products.pcsProduct('minus', <?php echo \eMarket\Catalog\Products::$products['id'] ?>, <?php echo \eMarket\Catalog\Products::$products['quantity'] ?>)"><span class="glyphicon glyphicon-minus"></span></button>
                    <input id="number_<?php echo \eMarket\Catalog\Products::$products['id'] ?>" data-placement="top" data-content="<?php echo lang('listing_no_more_in_stock') ?>" type="number" min="1" value="<?php echo \eMarket\Cart::maxQuantityToOrder(\eMarket\Catalog\Products::$products) ?>" class="quantity" disabled>
                    <button class="btn btn-primary button-plus" type="button" onclick="Products.pcsProduct('plus', <?php echo \eMarket\Catalog\Products::$products['id'] ?>, <?php echo \eMarket\Cart::maxQuantityToOrder(\eMarket\Catalog\Products::$products, 'true') ?>)"><span class="glyphicon glyphicon-plus"></span></button>
                    <button class="btn btn-primary plus<?php echo \eMarket\Cart::maxQuantityToOrder(\eMarket\Catalog\Products::$products, 'class') ?>" onclick="Products.addToCart(<?php echo \eMarket\Catalog\Products::$products['id'] ?>, $('#number_<?php echo \eMarket\Catalog\Products::$products['id'] ?>').val())"><?php echo lang('add_to_cart') ?></button>
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
                        <div class="item-text"><?php echo \eMarket\Catalog\Products::$products['description'] ?></div>
                    </div>
                    <!-- Содержимое панели Характеристики -->
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

// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach (\eMarket\View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
?>