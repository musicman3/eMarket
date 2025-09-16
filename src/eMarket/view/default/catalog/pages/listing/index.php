<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Ecb,
    Pages,
    Products,
    Valid,
    Routing
};
use eMarket\Catalog\{
    Cart,
    Listing
};

require_once('modal/cart_message.php')
?>

<?php if (Valid::inGET('search')) { ?><h1><?php echo lang('listing_search'); ?></h1><?php } else { ?><h1><?php echo Listing::$categories_name ?></h1><?php } ?>

<div id="ajax_data" class='hidden' data-product='<?php echo Listing::$product_edit ?>'></div>

<?php if (Listing::$categories_description != null) { ?>
    <div class="container-fluid">
        <div class="row">
            <div id="listing-block" class="mb-3 p-3 border rounded">
                <?php if (is_file(getenv('DOCUMENT_ROOT') . '/uploads/images/categories/resize_2/' . Listing::$categories_logo)) { ?>
                    <img src="/uploads/images/categories/resize_2/<?php echo Listing::$categories_logo ?>" class="thumbnail img-fluid float-md-end mb-3 ms-md-3" alt="<?php echo Listing::$categories_name ?>">
                    <?php
                }
                echo Listing::$categories_description
                ?>
            </div>
        </div>
    </div>
    <?php
}
foreach (Routing::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
if (Pages::$count > 0) {
    ?>

    <div class="bg-light mb-3 p-2 border rounded">
        <div class="p-1 btn-group button-sort">
            <button type="button" class="btn btn-primary dropdown-toggle bi-arrow-down-up" data-bs-toggle="dropdown"> <?php echo Listing::$sort_name ?> </button>
            <ul class="dropdown-menu">
                <li><a id="default" class="sorting dropdown-item"><?php echo lang('listing_sort_by_default') ?></a></li>
                <li><a id="name" class="sorting dropdown-item"><?php echo lang('listing_sort_by_name') ?></a></li>
                <li><a id="down" class="sorting dropdown-item"><?php echo lang('listing_sort_by_price_desc') ?></a></li>
                <li><a id="up" class="sorting dropdown-item"><?php echo lang('listing_sort_by_price_asc') ?></a></li>
            </ul>
        </div>

        <div class="p-1 btn-group switch">
            <input type="radio" class="btn-check" name="show_in_stock" id="primary-outlined" autocomplete="off" <?php echo Listing::$checked_stock ?>>
            <label class="btn btn-outline-primary" for="primary-outlined"><?php echo lang('button-all-switch') ?></label>
            <input type="radio" class="btn-check" name="show_in_stock" id="success-outlined" autocomplete="off">
            <label class="btn btn-outline-success" for="success-outlined"><?php echo lang('button-instock-switch') ?></label>
        </div>

        <div class="p-1 btn-group float-end hidden-grid-list">
            <a id="list" class="btn btn-outline-secondary item-list bi-list active"></a>
            <a id="grid" class="btn btn-outline-secondary item-grid bi-grid-3x3-gap"></a>
        </div>
    </div>

    <div id="listing" class="contentText">

        <div id="product-data" class="row">
            <?php
            for (Pages::$start;
                    Pages::$start < Pages::$finish;
                    Pages::$start++, Pages::lineUpdate()) {
                ?>
                <div class="item mb-3 col-xl-3 col-lg-4 col-md-6 col-12 grid-group-item">
                    <div class="cards card border rounded p-2 h-100">

                        <div class="d-flex h-75">
                            <div class="labelsblock">
                                <?php foreach (Products::stickers(Pages::$table['line'], 'bg-danger', 'bg-success') as $sticker) { ?>
                                    <div class="<?php echo $sticker[0] ?>"><?php echo $sticker[1] ?></div>
                                <?php } ?>
                            </div>
                            <div class="image text-center mb-2 p-3">
                                <a href="/?route=products&id=<?php echo Pages::$table['line']['id'] ?>">
                                    <img src="/uploads/images/products/resize_2/<?php echo Pages::$table['line']['logo_general'] ?>" alt="<?php echo Pages::$table['line']['name'] ?>" class="w-100 img-fluid rounded mx-auto d-block mb-2">
                                </a>
                            </div>
                            <div class="ms-auto text-end w-100">
                                <h5 class="item-heading"><a href="/?route=products&id=<?php echo Pages::$table['line']['id'] ?>"><?php echo Pages::$table['line']['name'] ?></a></h5>
                                <div class="item-price mb-2"><?php echo Ecb::priceInterface(Pages::$table['line'], 2) ?></div>
                                <div class="item-text mb-2">
                                    <ul>
                                        <?php foreach (Listing::getCharData() as $val) { ?>
                                            <li>
                                                <label><?php echo $val['label'] ?> </label> 
                                                <?php echo $val['text'] ?>
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
                            </div>
                        </div>
                        <div class="h-25">
                            <div class="buttons-block text-end d-flex justify-content-center align-items-center h-100 w-100 d-grid gap-1">
                                <button class="btn btn-outline-primary bi-dash" type="button" onclick="ProductsListing.pcsProduct('minus', <?php echo Pages::$table['line']['id'] ?>)"></button>
                                <input id="number_<?php echo Pages::$table['line']['id'] ?>" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="<?php echo lang('listing_no_more_in_stock') ?>" type="number" min="1" value="<?php echo Cart::maxQuantityToOrder(Pages::$table['line']) ?>" class="quantity" disabled>
                                <button class="btn btn-outline-primary button-plus bi-plus" type="button" onclick="ProductsListing.pcsProduct('plus', <?php echo Pages::$table['line']['id'] ?>, <?php echo Cart::maxQuantityToOrder(Pages::$table['line'], 'true') ?>)"></button>
                                <button class="btn btn-primary buy-now<?php echo Cart::maxQuantityToOrder(Pages::$table['line'], 'class') ?>" onclick="ProductsListing.addToCart(<?php echo Pages::$table['line']['id'] ?>, document.querySelector('#number_<?php echo Pages::$table['line']['id'] ?>').value)"><?php echo lang('buy_now') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>  
        </div>

        <div class="d-flex mb-3 bg-light mb-3 p-2 border rounded">
            <div id="nav_data" class='hidden' 
                 data-prev='<?php echo Pages::$table['navigate'][0] ?>'
                 data-next='<?php echo Pages::$table['navigate'][1] ?>'
                 data-sortflag='<?php echo Listing::$sort_flag ?>'
                 ></div>
            <div class="mt-2 mb-2 p-1 btn-group"><?php echo Pages::counterPage() ?></div>

            <div class="align-self-start btn-group ms-auto p-1 navigate-normal">
                <?php if (Pages::$table['navigate'][0] > 0) { ?> 
                    <button id="prev" type="button" class="btn btn-outline-secondary navigation"><span class="bi bi-arrow-left"></span><?php echo lang('button_previous') ?></button>
                <?php } else { ?> 
                    <a id="prev" class="btn btn-outline-secondary disabled"><span class="bi bi-arrow-left"></span><?php echo lang('button_previous') ?></a>
                    <?php
                }
                if (Pages::$table['navigate'][1] != Pages::$count) {
                    ?> 
                    <button id="next" type="button" class="btn btn-outline-secondary navigation"><?php echo lang('button_next') ?> <span class="bi bi-arrow-right"></span></button>
                <?php } else { ?> 
                    <a id="next" class="btn btn-outline-secondary disabled"><?php echo lang('button_next') ?> <span class="bi bi-arrow-right"></span></a>
                <?php } ?>
            </div>
            <div class="align-self-start btn-group ms-auto p-1 navigate-mini">
                <?php if (Pages::$table['navigate'][0] > 0) { ?> 
                    <button id="prev" type="button" class="btn btn-outline-secondary navigation"><span class="bi bi-arrow-left"></span></button>
                <?php } else { ?> 
                    <a id="prev" class="btn btn-outline-secondary disabled"><span class="bi bi-arrow-left"></span></a>
                    <?php
                }
                if (Pages::$table['navigate'][1] != Pages::$count) {
                    ?> 
                    <button id="next" type="button" class="btn btn-outline-secondary navigation"><span class="bi bi-arrow-right"></span></button>
                <?php } else { ?> 
                    <a id="next" class="btn btn-outline-secondary disabled"><span class="bi bi-arrow-right"></span></a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } elseif (Valid::inGET('search')) { ?>
    <div id="listing" class="contentText">
        <div class="bg-light border rounded mb-3 py-3 px-2">
            <p class="card-text"><?php echo lang('listing_no_search') ?></p>
        </div>
    </div>
    <?php
}