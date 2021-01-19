<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Cart,
    Ecb,
    Pages,
    Products,
    Valid,
    View
};
use \eMarket\Catalog\Listing;

foreach (View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
require_once('modal/cart_message.php')
?>

<?php if (Valid::inGET('search')) { ?><h1><?php echo lang('listing_search'); ?></h1><?php } else { ?><h1><?php echo Listing::$categories_name ?></h1><?php } ?>

<div id="ajax_data" class='hidden' data-product='<?php echo Listing::$product_edit ?>'></div>

<?php if (Pages::$count > 0) { ?>
    <div id="listing" class="contentText">
        <div class="well well-sm">
            <div class="btn-group">
                <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-sort"></span> &nbsp;<?php echo Listing::$sort_name ?></button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a id="default" class="sorting"><?php echo lang('listing_sort_by_default') ?></a></li>
                    <li><a id="name" class="sorting"><?php echo lang('listing_sort_by_name') ?></a></li>
                    <li><a id="down" class="sorting"><?php echo lang('listing_sort_by_price_desc') ?></a></li>
                    <li><a id="up" class="sorting"><?php echo lang('listing_sort_by_price_asc') ?></a></li>
                </ul>

                &nbsp;&nbsp;<input class="check-box" hidden type="checkbox" data-off-color="success" data-size="normal" data-label-text="<?php echo lang('button-view-switch') ?>" data-label-width='auto' data-on-text="<?php echo lang('button-all-switch') ?>" data-off-text="<?php echo lang('button-instock-switch') ?>" data-handle-width="auto" name="show_in_stock" id="show_in_stock"<?php echo Listing::$checked_stock ?>>
            </div>

            <div class="btn-group pull-right hidden-grid-list">
                <a id="grid" class="btn btn-default item-grid active"><span class="glyphicon glyphicon-th"></span></a>
                <a id="list" class="btn btn-default item-list"><span class="glyphicon glyphicon-th-list"></span></a>
            </div>
        </div>

        <div id="product-data" class="row row-flex">
            <?php
            for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) {
                ?>
                <div class="item col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item">
                    <div class="productHolder">
                        <?php echo Products::stikers(Pages::$table['line'], 'label-danger', 'label-success') ?>
                        <a href="/?route=products&category_id=<?php echo Pages::$table['line']['parent_id'] ?>&id=<?php echo Pages::$table['line']['id'] ?>"><img src="/uploads/images/products/resize_1/<?php echo Pages::$table['line']['logo_general'] ?>" alt="<?php echo Pages::$table['line']['name'] ?>" class="img-responsive"></a>
                        <div class="caption">
                            <h5 class="item-heading"><a href="/?route=products&category_id=<?php echo Pages::$table['line']['parent_id'] ?>&id=<?php echo Pages::$table['line']['id'] ?>"><?php echo Pages::$table['line']['name'] ?></a></h5>
                            <div class="item-price"><?php echo Ecb::priceInterface(Pages::$table['line'], 1) ?></div>
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
                                        <?php echo Products::inStock(Pages::$table['line']['date_available'], Pages::$table['line']['quantity']); ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="block-button">
                                    <button class="btn btn-primary" type="button" onclick="ProductsListing.pcsProduct('minus', <?php echo Pages::$table['line']['id'] ?>)"><span class="glyphicon glyphicon-minus"></span></button>
                                    <input id="number_<?php echo Pages::$table['line']['id'] ?>" data-placement="top" data-content="<?php echo lang('listing_no_more_in_stock') ?>" type="number" min="1" value="<?php echo Cart::maxQuantityToOrder(Pages::$table['line']) ?>" class="quantity" disabled>
                                    <button class="btn btn-primary button-plus" type="button" onclick="ProductsListing.pcsProduct('plus', <?php echo Pages::$table['line']['id'] ?>, <?php echo Cart::maxQuantityToOrder(Pages::$table['line'], 'true') ?>)"><span class="glyphicon glyphicon-plus"></span></button>
                                    <button class="btn btn-primary buy-now<?php echo Cart::maxQuantityToOrder(Pages::$table['line'], 'class') ?>" onclick="ProductsListing.addToCart(<?php echo Pages::$table['line']['id'] ?>, $('#number_<?php echo Pages::$table['line']['id'] ?>').val())"><?php echo lang('buy_now') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>  
        </div>

        <div class="well well-sm">
            <div id="nav_data" class='hidden' 
                 data-prev='<?php echo Pages::$table['navigate'][0] ?>'
                 data-next='<?php echo Pages::$table['navigate'][1] ?>'
                 data-sortflag='<?php echo Listing::$sort_flag ?>'
                 ></div>
            <div class="result-inner btn-group"><?php echo Pages::counterPage() ?></div>

            <div class="btn-group pull-right navigate-normal">
                <?php if (Pages::$table['navigate'][0] > 0) { ?> 
                    <button id="prev" type="button" class="btn btn-default navigation">&larr; <?php echo lang('button_previous') ?></button>
                <?php } else { ?> 
                    <a id="prev" class="btn btn-default disabled">&larr; <?php echo lang('button_previous') ?></a>
                    <?php
                }
                if (Pages::$table['navigate'][1] != Pages::$count) {
                    ?> 
                    <button id="next" type="button" class="btn btn-default navigation"><?php echo lang('button_next') ?> &rarr;</button>
                <?php } else { ?> 
                    <a id="next" class="btn btn-default disabled"><?php echo lang('button_next') ?> &rarr;</a>
                <?php } ?>
            </div>
            <div class="btn-group pull-right navigate-mini">
                <?php if (Pages::$table['navigate'][0] > 0) { ?> 
                    <button id="prev" type="button" class="btn btn-default navigation">&larr;</button>
                <?php } else { ?> 
                    <a id="prev" class="btn btn-default disabled">&larr;</a>
                    <?php
                }
                if (Pages::$table['navigate'][1] != Pages::$count) {
                    ?> 
                    <button id="next" type="button" class="btn btn-default navigation">&rarr;</button>
                <?php } else { ?> 
                    <a id="next" class="btn btn-default disabled">&rarr;</a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div id="listing" class="contentText">
        <div class="well well-sm">
            <div class="no">
                <?php
                if (Valid::inGET('search')) {
                    echo lang('listing_no_search');
                } else {
                    echo lang('listing_no');
                }
                ?>
            </div>
        </div>
    </div>
<?php }
