<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Ecb,
    Messages,
    Products as ProductsCore
};
use eMarket\Catalog\{
    Products,
    Cart
};
use eMarket\Admin\Templates;

if (Products::$products != FALSE) {
    require_once('modal/cart_message.php')
    ?>

    <h1><?php echo Products::$products['name'] ?></h1>

    <div id="alert_block"><?php Messages::alert(); ?></div>

    <div id="products" class="contentText">
        <div class="row">
            <div class="gallery col-xl-5 col-md-5 col-12 mb-2">
                <input id="selected_attributes" type="hidden" name="selected_attributes" value="" />

                <div class="row d-flex justify-content-center">
                    <div class="d-flex align-items-center h-100">
                        <div class="labelsblock">
                            <?php foreach (ProductsCore::stickers(Products::$products, 'bg-danger', 'bg-success') as $sticker) { ?>
                                <div class="<?php echo $sticker[0] ?>"><?php echo $sticker[1] ?></div>
                            <?php } ?>
                        </div>
                        <a href="/uploads/images/products/resize_4/<?php echo Products::$products['logo_general'] ?>">
                            <img src="/uploads/images/products/resize_4/<?php echo Products::$products['logo_general'] ?>" alt="<?php echo Products::$products['name'] ?>" class="img-fluid rounded d-block mb-3">
                        </a>
                    </div>

                    <?php foreach (Products::$images as $val) { ?>
                        <div class="col-xl-2 col-md-4 col-12 p-1">
                            <a href="/uploads/images/products/resize_4/<?php echo $val ?>">
                                <img src="/uploads/images/products/resize_0/<?php echo $val ?>" alt="<?php echo Products::$products['name'] ?>" class="img-thumbnail">
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-1 col-12"></div>
            <div class="col-md-6 col-12 mb-3 productpage">
                <?php if (Products::$products['price'] > 0) { ?>
                    <ul>
                        <li>
                            <span class="productpage-price"><?php echo Ecb::priceInterface(Products::$products, 2) ?></span>
                        </li>
                    </ul>
                <?php } ?>
                <hr>
                <div class="mb-3 p-1">
                    <?php if (Products::$manufacturer_logo != '' && Products::$manufacturer_logo != null) { ?>
                        <a href="<?php echo Products::$manufacturer_site ?>" target="_blank">
                            <img src="/uploads/images/manufacturers/resize_0/<?php echo Products::$manufacturer_logo ?>" alt="<?php echo Products::$manufacturer ?>" class="float-md-end mb-3 ms-md-3" title="<?php echo Products::$manufacturer ?>">
                        </a>

                    <?php } ?>
                    <ul>

                        <?php foreach (Products::$info_block as $info) { ?>
                            <li>
                                <label><?php echo $info['label'] ?>:</label>
                                <span> <?php echo $info['data'] ?></span>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
                <hr>
                <?php if (Products::$products['price'] > 0) { ?>
                    <button class="btn btn-outline-primary bi-dash" type="button" onclick="Products.pcsProduct('minus', <?php echo Products::$products['id'] ?>, <?php echo Products::$products['quantity'] ?>)"></button>
                    <input id="number_<?php echo Products::$products['id'] ?>" data-bs-placement="top" data-bs-content="<?php echo lang('listing_no_more_in_stock') ?>" type="number" min="1" value="<?php echo Cart::maxQuantityToOrder(Products::$products) ?>" class="quantity" disabled>
                    <button class="btn btn-outline-primary button-plus bi-plus" type="button" onclick="Products.pcsProduct('plus', <?php echo Products::$products['id'] ?>, <?php echo Cart::maxQuantityToOrder(Products::$products, 'true') ?>)"></button>
                    <button class="btn btn-primary plus<?php echo Cart::maxQuantityToOrder(Products::$products, 'class') ?>" onclick="Products.addToCart(<?php echo Products::$products['id'] ?>, document.querySelector('#number_<?php echo Products::$products['id'] ?>').value)"><?php echo lang('add_to_cart') ?></button>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="contentText">
                <div class="list-group-item border-0">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#panel_description"><?php echo lang('product_description') ?></a></li>
                        <?php if (Products::$attributes_status) { ?>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#panel_attribute"><?php echo lang('product_specification') ?></a></li>
                            <?php
                        }
                        foreach (Products::$tabs_data as $tabs) {
                            ?>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#panel_<?php echo $tabs['chanel_module_name'] ?>"><?php echo $tabs['chanel_name'] ?></a></li>
                        <?php }
                        ?>
                    </ul>
                    <div class="tab-content">
                        <div id="panel_description" class="tab-pane fade show active">
                            <div class="item-text border border-top-0 rounded-bottom p-2"><?php echo Products::$products['description'] ?></div>
                        </div>
                        <?php if (Products::$attributes_status) { ?>
                            <div id="panel_attribute" class="tab-pane fade show">
                                <div class="item-text border border-top-0 rounded-bottom p-2 product-attribute"></div>
                            </div>
                            <?php
                        }
                        foreach (Products::$tabs_data as $tabs) {
                            require_once(ROOT . '/modules/tabs/' . $tabs['chanel_module_name'] . '/view/catalog/index.php');
                        }
                        ?>
                    </div>
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

foreach (Templates::tlpc('content') as $path) {
    require_once (ROOT . $path);
}    