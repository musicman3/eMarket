<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Cart,
    Ecb,
    Messages,
    Products as ProductsCore,
    View
};
use eMarket\Catalog\{
    Products
};

if (Products::$products != FALSE) {
    require_once('modal/cart_message.php')
    ?>

    <h1><?php echo Products::$products['name'] ?></h1>

    <div id="alert_block"><?php Messages::alert(); ?></div>

    <div id="products" class="contentText">
        <div class="row">
            <div class="gallery col-md-6 col-12 mb-3">
                <input id="selected_attributes" type="hidden" name="selected_attributes" value="" />

                <div class="labelsblock">
                    <?php foreach (ProductsCore::stickers(Products::$products, 'bg-danger', 'bg-success') as $sticker) { ?>
                        <div class="<?php echo $sticker[0] ?>"><?php echo $sticker[1] ?></div>
                    <?php } ?>
                </div>

                <a href="/uploads/images/products/resize_4/<?php echo Products::$products['logo_general'] ?>">
                    <img src="/uploads/images/products/resize_2/<?php echo Products::$products['logo_general'] ?>" alt="<?php echo Products::$products['name'] ?>" class="img-fluid rounded mx-auto d-block mb-3 ">
                </a>
                <div class="row justify-content-center">
                    <?php foreach (Products::$images as $val) { ?>
                        <div class="col-xl-3 col-md-4 col-5">
                            <a href="/uploads/images/products/resize_4/<?php echo $val ?>">
                                <img src="/uploads/images/products/resize_1/<?php echo $val ?>" alt="<?php echo Products::$products['name'] ?>" class="img-thumbnail">
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-6 col-12 mb-3 productpage">
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
                        <?php foreach (ProductsCore::inStock(Products::$products['date_available'], Products::$products['quantity']) as $in_stock) { ?>
                            <span class="<?php echo $in_stock[0] ?>"><?php echo $in_stock[1] ?></span>
                        <?php } ?>
                    </li>
                </ul>
                <hr>
                <button class="btn btn-primary bi-dash" type="button" onclick="Products.pcsProduct('minus', <?php echo Products::$products['id'] ?>, <?php echo Products::$products['quantity'] ?>)"></button>
                <input id="number_<?php echo Products::$products['id'] ?>" data-bs-placement="top" data-bs-content="<?php echo lang('listing_no_more_in_stock') ?>" type="number" min="1" value="<?php echo Cart::maxQuantityToOrder(Products::$products) ?>" class="quantity" disabled>
                <button class="btn btn-primary button-plus bi-plus" type="button" onclick="Products.pcsProduct('plus', <?php echo Products::$products['id'] ?>, <?php echo Cart::maxQuantityToOrder(Products::$products, 'true') ?>)"></button>
                <button class="btn btn-primary plus<?php echo Cart::maxQuantityToOrder(Products::$products, 'class') ?>" onclick="Products.addToCart(<?php echo Products::$products['id'] ?>, document.querySelector('#number_<?php echo Products::$products['id'] ?>').value)"><?php echo lang('add_to_cart') ?></button>
            </div>
        </div>
        <div class="row">
            <div class="list-group-item border-0">
                <ul class="nav nav-tabs">
                    <li class="nav-item bg-light"><a class="nav-link active" data-bs-toggle="tab" href="#panel_description"><?php echo lang('product_description') ?></a></li>
                    <li class="nav-item bg-light"><a class="nav-link" data-bs-toggle="tab" href="#panel_attribute"><?php echo lang('product_specification') ?></a></li>
                    <?php foreach (Products::$tabs_data as $tabs) { ?>
                        <li class="nav-item bg-light"><a class="nav-link" data-bs-toggle="tab" href="#panel_<?php echo $tabs['chanel_module_name'] ?>"><?php echo $tabs['chanel_name'] ?></a></li>
                    <?php }
                    ?>
                </ul>
                <div class="tab-content">
                    <div id="panel_description" class="tab-pane fade show active">
                        <div class="item-text border border-top-0 rounded-bottom p-2"><?php echo Products::$products['description'] ?></div>
                    </div>
                    <div id="panel_attribute" class="tab-pane fade show">
                        <div class="item-text border border-top-0 rounded-bottom p-2 product-attribute"></div>
                    </div>
                        <?php foreach (Products::$tabs_data as $tabs) {
                            require_once(ROOT. '/modules/tabs/' . $tabs['chanel_module_name'] . '/controller/catalog/index.php');
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>


<?php } else {
    ?>
    <h1><?php echo lang('product_not_found') ?></h1>

    <div id="products" class="contentText">
        <div class="bg-light border rounded mb-3 py-3 px-2">
            <p class="card-text"><?php echo lang('product_not_found_message') ?></p>
        </div>
    </div>
    <?php
}

foreach (View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}    