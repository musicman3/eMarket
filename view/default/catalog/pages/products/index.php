<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if ($products != FALSE) {
    ?>

    <h1><?php echo $products['name'] ?></h1>

    <div id="products" class="contentText">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <a href="/uploads/images/products/resize_4/<?php echo $products['logo_general'] ?>" data-toggle="lightbox" data-gallery="example-gallery" data-type="image">
                    <img src="/uploads/images/products/resize_2/<?php echo $products['logo_general'] ?>" alt="<?php echo $products['name'] ?>" class="img-padding img-responsive center-block">
                </a>
                <div class="row">
                    <?php foreach ($images as $val) { ?>
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <a href="/uploads/images/products/resize_4/<?php echo $val ?>" data-toggle="lightbox" data-gallery="example-gallery" data-type="image" class="thumbnail">
                                <img src="/uploads/images/products/resize_1/<?php echo $val ?>" alt="<?php echo $products['name'] ?>">
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 productpage">
                <ul>
                    <li>
                        <span class="productpage-price"><?php echo \eMarket\Ecb::priceInterface($products, 1) ?></span>
                    </li>
                </ul>
                <hr>
                <ul>
                    <?php if ($vendor_code_value != NULL && $vendor_code_value != '') { ?>
                        <li>
                            <label><?php echo $vendor_code ?>:</label>
                            <span> <?php echo $vendor_code_value ?></span>
                        </li>
                    <?php } if ($manufacturer != NULL && $manufacturer != FALSE) { ?>
                        <li>
                            <label><?php echo lang('product_manufacturer') ?></label>
                            <span> <?php echo $manufacturer ?></span>
                        </li>
                    <?php } if ($products['model'] != NULL && $products['model'] != FALSE) { ?>
                        <li>
                            <label><?php echo lang('product_model') ?></label>
                            <span> <?php echo $products['model'] ?></span>
                        </li>
                    <?php } if ($weight_value != NULL && $weight_value != '') { ?>
                        <li>
                            <label><?php echo lang('product_weight') ?></label>
                            <span> <?php echo $weight_value . ' ' . $weight ?> </span>
                        </li>
                    <?php } if ($dimensions != '') { ?>
                        <li>
                            <label><?php echo sprintf(lang('product_dimension'), $dimension_name) ?></label>
                            <span> <?php echo $dimensions ?></span>
                        </li>
                    <?php } ?>
                    <li>
                        <label><?php echo lang('product_availability') ?></label>
                        <?php if ($instock['date_available_marker'] == 'false') { ?>
                            <span class="label label-warning"><?php echo $instock['date_available_text'] ?></span>
                        <?php } elseif ($products['quantity'] != NULL && $products['quantity'] <= 0) { ?>
                            <span class="label label-danger"><?php echo $instock['date_available_text'] ?></span>
                        <?php } else { ?>
                            <span class="label label-success"><?php echo $instock['date_available_text'] ?></span>
                        <?php } ?>
                    </li>
                </ul>
                <hr>
                <div>
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
        <div class="row">
            <div class="list-group-item">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#panel_description"><?php echo lang('product_description') ?></a></li>
                    <li><a data-toggle="tab" href="#panel_attribute"><?php echo lang('product_specification') ?></a></li>
                </ul>
                <div class="tab-content">
                    <div id="panel_description" class="tab-pane fade in active">
                        <div class="item-text"><?php echo $products['description'] ?></div>
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
foreach (\eMarket\View::layoutRouting('content') as $path) {
    require_once (ROOT . $path);
}
?>