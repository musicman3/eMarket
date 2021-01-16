<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach (\eMarket\View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
?>
<!-- Модальное окно -->
<?php require_once('modal/cart_message.php') ?>
<!-- КОНЕЦ Модальное окно -->

<?php if (\eMarket\Valid::inGET('search')) { ?><h1><?php echo lang('listing_search'); ?></h1><?php } else { ?><h1><?php echo \eMarket\Catalog\Listing::$categories_name ?></h1><?php } ?>

<div id="ajax_data" class='hidden' data-product='<?php echo \eMarket\Catalog\Listing::$product_edit ?>'></div>

<?php if (\eMarket\Pages::$count > 0) { ?>
    <div id="listing" class="contentText">
        <div class="well well-sm">
            <div class="btn-group">
                <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-sort"></span> &nbsp;<?php echo \eMarket\Catalog\Listing::$sort_name ?></button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a id="default" class="sorting"><?php echo lang('listing_sort_by_default') ?></a></li>
                    <li><a id="name" class="sorting"><?php echo lang('listing_sort_by_name') ?></a></li>
                    <li><a id="down" class="sorting"><?php echo lang('listing_sort_by_price_desc') ?></a></li>
                    <li><a id="up" class="sorting"><?php echo lang('listing_sort_by_price_asc') ?></a></li>
                </ul>

                &nbsp;&nbsp;<input class="check-box" hidden type="checkbox" data-off-color="success" data-size="normal" data-label-text="<?php echo lang('button-view-switch') ?>" data-label-width='auto' data-on-text="<?php echo lang('button-all-switch') ?>" data-off-text="<?php echo lang('button-instock-switch') ?>" data-handle-width="auto" name="show_in_stock" id="show_in_stock"<?php echo \eMarket\Catalog\Listing::$checked_stock ?>>
            </div>

            <div class="btn-group pull-right hidden-grid-list">
                <a id="grid" class="btn btn-default item-grid active"><span class="glyphicon glyphicon-th"></span></a>
                <a id="list" class="btn btn-default item-list"><span class="glyphicon glyphicon-th-list"></span></a>
            </div>
        </div>

        <div id="product-data" class="row row-flex">
            <?php
            for (\eMarket\Pages::$start; \eMarket\Pages::$start < \eMarket\Pages::$finish; \eMarket\Pages::$start++, \eMarket\Pages::lineUpdate()) {
                ?>
                <div class="item col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item">
                    <div class="productHolder">
                        <?php echo \eMarket\Products::stikers(eMarket\Pages::$table['line'], 'label-danger', 'label-success') ?>
                        <a href="/?route=products&category_id=<?php echo eMarket\Pages::$table['line']['parent_id'] ?>&id=<?php echo eMarket\Pages::$table['line']['id'] ?>"><img src="/uploads/images/products/resize_1/<?php echo eMarket\Pages::$table['line']['logo_general'] ?>" alt="<?php echo eMarket\Pages::$table['line']['name'] ?>" class="img-responsive"></a>
                        <div class="caption">
                            <h5 class="item-heading"><a href="/?route=products&category_id=<?php echo eMarket\Pages::$table['line']['parent_id'] ?>&id=<?php echo eMarket\Pages::$table['line']['id'] ?>"><?php echo eMarket\Pages::$table['line']['name'] ?></a></h5>
                            <div class="item-price"><?php echo \eMarket\Ecb::priceInterface(eMarket\Pages::$table['line'], 1) ?></div>
                            <div class="item-text">
                                <ul>
                                    <?php if (eMarket\Pages::$table['line']['vendor_code'] != NULL && eMarket\Pages::$table['line']['vendor_code'] != FALSE && eMarket\Pages::$table['line']['vendor_code_value'] != NULL && eMarket\Pages::$table['line']['vendor_code_value'] != FALSE) { ?>
                                        <li>
                                            <label><?php echo \eMarket\Products::vendorCode(eMarket\Pages::$table['line']['vendor_code'])['name'] ?>: </label> 
                                            <?php echo eMarket\Pages::$table['line']['vendor_code_value'] ?>
                                        </li>
				    <?php } if (\eMarket\Products::manufacturer(eMarket\Pages::$table['line']['manufacturer'])['name'] != NULL && \eMarket\Products::manufacturer(eMarket\Pages::$table['line']['manufacturer'])['name'] != FALSE) { ?>
                                        <li>
                                            <label><?php echo lang('product_manufacturer') ?></label> <?php echo \eMarket\Products::manufacturer(eMarket\Pages::$table['line']['manufacturer'])['name'] ?>
                                        </li>
                                    <?php } if (eMarket\Pages::$table['line']['model'] != NULL && eMarket\Pages::$table['line']['model'] != FALSE) { ?>
                                        <li>
                                            <label><?php echo lang('product_model') ?></label> 
                                            <?php echo eMarket\Pages::$table['line']['model'] ?>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <label><?php echo lang('product_availability') ?></label>
                                        <?php echo \eMarket\Products::inStock(eMarket\Pages::$table['line']['date_available'], eMarket\Pages::$table['line']['quantity']); ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="block-button">
                                    <button class="btn btn-primary" type="button" onclick="ProductsListing.pcsProduct('minus', <?php echo eMarket\Pages::$table['line']['id'] ?>)"><span class="glyphicon glyphicon-minus"></span></button>
                                    <input id="number_<?php echo eMarket\Pages::$table['line']['id'] ?>" data-placement="top" data-content="<?php echo lang('listing_no_more_in_stock') ?>" type="number" min="1" value="<?php echo \eMarket\Cart::maxQuantityToOrder(eMarket\Pages::$table['line']) ?>" class="quantity" disabled>
                                    <button class="btn btn-primary button-plus" type="button" onclick="ProductsListing.pcsProduct('plus', <?php echo eMarket\Pages::$table['line']['id'] ?>, <?php echo \eMarket\Cart::maxQuantityToOrder(eMarket\Pages::$table['line'], 'true') ?>)"><span class="glyphicon glyphicon-plus"></span></button>
                                    <button class="btn btn-primary buy-now<?php echo \eMarket\Cart::maxQuantityToOrder(eMarket\Pages::$table['line'], 'class') ?>" onclick="ProductsListing.addToCart(<?php echo eMarket\Pages::$table['line']['id'] ?>, $('#number_<?php echo eMarket\Pages::$table['line']['id'] ?>').val())"><?php echo lang('buy_now') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>  
        </div>

        <div class="well well-sm">
            <!--Скрытый div для передачи данных-->
            <div id="nav_data" class='hidden' 
                 data-prev='<?php echo eMarket\Pages::$table['navigate'][0] ?>'
                 data-next='<?php echo eMarket\Pages::$table['navigate'][1] ?>'
                 data-sortflag='<?php echo \eMarket\Catalog\Listing::$sort_flag ?>'
                 ></div>
            <div class="result-inner btn-group"><?php echo \eMarket\Pages::counterPage() ?></div>

            <div class="btn-group pull-right navigate-normal">
                <?php if (eMarket\Pages::$table['navigate'][0] > 0) { ?> 
                    <button id="prev" type="button" class="btn btn-default navigation">&larr; <?php echo lang('button_previous') ?></button>
                <?php } else { ?> 
                    <a id="prev" class="btn btn-default disabled">&larr; <?php echo lang('button_previous') ?></a>
                    <?php
                }
                if (eMarket\Pages::$table['navigate'][1] != \eMarket\Pages::$count) {
                    ?> 
                    <button id="next" type="button" class="btn btn-default navigation"><?php echo lang('button_next') ?> &rarr;</button>
                <?php } else { ?> 
                    <a id="next" class="btn btn-default disabled"><?php echo lang('button_next') ?> &rarr;</a>
                <?php } ?>
            </div>
            <div class="btn-group pull-right navigate-mini">
                <?php if (eMarket\Pages::$table['navigate'][0] > 0) { ?> 
                    <button id="prev" type="button" class="btn btn-default navigation">&larr;</button>
                <?php } else { ?> 
                    <a id="prev" class="btn btn-default disabled">&larr;</a>
                    <?php
                }
                if (eMarket\Pages::$table['navigate'][1] != \eMarket\Pages::$count) {
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
                if (\eMarket\Valid::inGET('search')) {
                    echo lang('listing_no_search');
                } else {
                    echo lang('listing_no');
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>
