<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Cart,
    Ecb,
    Pages,
    Products,
    Valid,
    View
};
use eMarket\Catalog\Listing;

foreach (View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
require_once('modal/cart_message.php')
?>

<?php if (Valid::inGET('search')) { ?><h1><?php echo lang('listing_search'); ?></h1><?php } else { ?><h1><?php echo Listing::$categories_name ?></h1><?php } ?>

<div id="ajax_data" class='hidden' data-product='<?php echo Listing::$product_edit ?>'></div>

<div id="listing-block" class="bg-light mb-3 p-2 border rounded">
    <div class="btn-group button-sort">
        <button type="button" class="btn btn-primary dropdown-toggle bi-arrow-down-up" data-bs-toggle="dropdown"> <?php echo Listing::$sort_name ?> </button>
        <ul class="dropdown-menu">
            <li><a id="default" class="sorting dropdown-item"><?php echo lang('listing_sort_by_default') ?></a></li>
            <li><a id="name" class="sorting dropdown-item"><?php echo lang('listing_sort_by_name') ?></a></li>
            <li><a id="down" class="sorting dropdown-item"><?php echo lang('listing_sort_by_price_desc') ?></a></li>
            <li><a id="up" class="sorting dropdown-item"><?php echo lang('listing_sort_by_price_asc') ?></a></li>
        </ul>
    </div>

    <div class="btn-group switch">
        <input type="radio" class="btn-check" name="show_in_stock" id="primary-outlined" autocomplete="off" <?php echo Listing::$checked_stock ?>>
        <label class="btn btn-outline-primary" for="primary-outlined"><?php echo lang('button-all-switch') ?></label>
        <input type="radio" class="btn-check" name="show_in_stock" id="success-outlined" autocomplete="off">
        <label class="btn btn-outline-success" for="success-outlined"><?php echo lang('button-instock-switch') ?></label>
    </div>

    <div class="btn-group float-end hidden-grid-list">
        <a id="grid" class="btn btn-outline-secondary item-grid active bi-grid-3x3-gap"></a>
        <a id="list" class="btn btn-outline-secondary item-list bi-list"></a>
    </div>
</div>

<?php if (Pages::$count > 0) { ?>
    <div id="listing" class="contentText">

        <div id="product-data" class="row">
            <?php
            for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) {
                ?>
                <div class="item mb-3 col-xl-3 col-lg-4 col-md-6 col-12 grid-group-item">
                    <div id="card" class="card border rounded p-2 h-100">

                        <div class="labelsblock">
                            <?php foreach (Products::stickers(Pages::$table['line'], 'bg-danger', 'bg-success') as $sticker) { ?>
                                <div class="<?php echo $sticker[0] ?>"><?php echo $sticker[1] ?></div>
                            <?php } ?>
                        </div>
                        <div id="image" class="h-100">
                        <a href="/?route=products&category_id=<?php echo Pages::$table['line']['parent_id'] ?>&id=<?php echo Pages::$table['line']['id'] ?>"><img src="/uploads/images/products/resize_1/<?php echo Pages::$table['line']['logo_general'] ?>" alt="<?php echo Pages::$table['line']['name'] ?>" class="img-fluid rounded mx-auto d-block mb-2"></a>
                        </div>
                        <h5 class="item-heading"><a href="/?route=products&category_id=<?php echo Pages::$table['line']['parent_id'] ?>&id=<?php echo Pages::$table['line']['id'] ?>"><?php echo Pages::$table['line']['name'] ?></a></h5>
                        <div class="item-price mb-2"><?php echo Ecb::priceInterface(Pages::$table['line'], 2) ?></div>
                        <div class="item-text">
                            <ul>
                                <?php if (Pages::$table['line']['vendor_code'] != NULL && Pages::$table['line']['vendor_code'] != FALSE && Pages::$table['line']['vendor_code_value'] != NULL && Pages::$table['line']['vendor_code_value'] != FALSE) { ?>
                                    <li>
                                        <label><?php echo Products::vendorCode(Pages::$table['line']['vendor_code'])['name'] ?>: </label> 
                                        <?php echo Pages::$table['line']['vendor_code_value'] ?>
                                    </li>
                                <?php } if (Products::manufacturer(Pages::$table['line']['manufacturer'])['name'] != NULL && Products::manufacturer(Pages::$table['line']['manufacturer'])['name'] != FALSE) { ?>
                                    <li>
                                        <label><?php echo lang('product_manufacturer') ?></label> <?php echo Products::manufacturer(Pages::$table['line']['manufacturer'])['name'] ?>
                                    </li>
                                <?php } if (Pages::$table['line']['model'] != NULL && Pages::$table['line']['model'] != FALSE) { ?>
                                    <li>
                                        <label><?php echo lang('product_model') ?></label> 
                                        <?php echo Pages::$table['line']['model'] ?>
                                    </li>
                                <?php } ?>
                                <li>
                                    <label><?php echo lang('product_availability') ?></label>
                                    <?php foreach (Products::inStock(Pages::$table['line']['date_available'], Pages::$table['line']['quantity']) as $in_stock) { ?>
                                        <span class="<?php echo $in_stock[0] ?>"><?php echo $in_stock[1] ?></span>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 item-button">
                            <div class="block-button">
                                <button class="btn btn-primary bi-dash" type="button" onclick="ProductsListing.pcsProduct('minus', <?php echo Pages::$table['line']['id'] ?>)"></button>
                                <input id="number_<?php echo Pages::$table['line']['id'] ?>" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="<?php echo lang('listing_no_more_in_stock') ?>" type="number" min="1" value="<?php echo Cart::maxQuantityToOrder(Pages::$table['line']) ?>" class="quantity" disabled>
                                <button class="btn btn-primary button-plus bi-plus" type="button" onclick="ProductsListing.pcsProduct('plus', <?php echo Pages::$table['line']['id'] ?>, <?php echo Cart::maxQuantityToOrder(Pages::$table['line'], 'true') ?>)"></button>
                                <button class="btn btn-primary buy-now<?php echo Cart::maxQuantityToOrder(Pages::$table['line'], 'class') ?>" onclick="ProductsListing.addToCart(<?php echo Pages::$table['line']['id'] ?>,  document.querySelector('#number_<?php echo Pages::$table['line']['id'] ?>').value)"><?php echo lang('buy_now') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>  
        </div>

        <div class="bg-light mb-3 p-2 border rounded">
            <div id="nav_data" class='hidden' 
                 data-prev='<?php echo Pages::$table['navigate'][0] ?>'
                 data-next='<?php echo Pages::$table['navigate'][1] ?>'
                 data-sortflag='<?php echo Listing::$sort_flag ?>'
                 ></div>
            <div class="mt-2 mb-2 btn-group"><?php echo Pages::counterPage() ?></div>

            <div class="btn-group float-end navigate-normal">
                <?php if (Pages::$table['navigate'][0] > 0) { ?> 
                    <button id="prev" type="button" class="btn btn-outline-secondary navigation">&larr; <?php echo lang('button_previous') ?></button>
                <?php } else { ?> 
                    <a id="prev" class="btn btn-outline-secondary disabled">&larr; <?php echo lang('button_previous') ?></a>
                    <?php
                }
                if (Pages::$table['navigate'][1] != Pages::$count) {
                    ?> 
                    <button id="next" type="button" class="btn btn-outline-secondary navigation"><?php echo lang('button_next') ?> &rarr;</button>
                <?php } else { ?> 
                    <a id="next" class="btn btn-outline-secondary disabled"><?php echo lang('button_next') ?> &rarr;</a>
                <?php } ?>
            </div>
            <div class="btn-group float-end navigate-mini">
                <?php if (Pages::$table['navigate'][0] > 0) { ?> 
                    <button id="prev" type="button" class="btn btn-outline-secondary navigation">&larr;</button>
                <?php } else { ?> 
                    <a id="prev" class="btn btn-outline-secondary disabled">&larr;</a>
                    <?php
                }
                if (Pages::$table['navigate'][1] != Pages::$count) {
                    ?> 
                    <button id="next" type="button" class="btn btn-outline-secondary navigation">&rarr;</button>
                <?php } else { ?> 
                    <a id="next" class="btn btn-outline-secondary disabled">&rarr;</a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div id="listing" class="contentText">
        <div class="bg-light border rounded mb-3 py-3 px-2">
            <p class="card-text">
                <?php
                if (Valid::inGET('search')) {
                    echo lang('listing_no_search');
                } else {
                    echo lang('listing_no');
                }
                ?>
            </p>
        </div>
    </div>
    <?php
}