<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach (\eMarket\View::layoutRouting('content') as $path) {
    require_once (ROOT . $path);
}
?>
<!-- Модальное окно -->
<?php require_once('modal/cart_message.php') ?>
<!-- КОНЕЦ Модальное окно -->

<?php if (\eMarket\Valid::inGET('search')) { ?><h1><?php echo lang('listing_search'); ?></h1><?php } else { ?><h1><?php echo $categories_name ?></h1><?php } ?>

<div id="ajax_data" class='hidden' data-product='<?php echo $product_edit ?>'></div>

<?php if ($count_lines > 0) { ?>
    <div id="listing" class="contentText">
        <div class="well well-sm">
            <div class="btn-group">
                <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-sort"></span> &nbsp;<?php echo $sort_name ?></button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                <ul class="dropdown-menu text-right">
                    <li><a id="default" class="sorting"><?php echo lang('listing_sort_by_default') ?></a></li>
                    <li><a id="name" class="sorting"><?php echo lang('listing_sort_by_name') ?></a></li>
                    <li><a id="down" class="sorting"><?php echo lang('listing_sort_by_price_desc') ?></a></li>
                    <li><a id="up" class="sorting"><?php echo lang('listing_sort_by_price_asc') ?></a></li>
                </ul>

                &nbsp;&nbsp;<input class="check-box" hidden type="checkbox" data-off-color="success" data-size="normal" data-label-text="<?php echo lang('button-view-switch') ?>" data-label-width='auto' data-on-text="<?php echo lang('button-all-switch') ?>" data-off-text="<?php echo lang('button-instock-switch') ?>" data-handle-width="80" name="show_in_stock" id="show_in_stock"<?php echo $checked_stock ?>>
            </div>

            <div class="btn-group pull-right hidden-grid-list">
                <a id="grid" class="btn btn-default item-grid active"><span class="glyphicon glyphicon-th"></span></a>
                <a id="list" class="btn btn-default item-list"><span class="glyphicon glyphicon-th-list"></span></a>
            </div>
        </div>

        <div id="product-data" class="row">
            <?php
            for ($start; $start < $finish; $start++) {
                $manufacturer = \eMarket\Products::nameToId($lines[$start]['manufacturer'], TABLE_MANUFACTURERS, 'name');
                ?>
                <div class="item col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item">
                    <div class="productHolder">
                        <a href="/?route=products&category_id=<?php echo $lines[$start]['parent_id'] ?>&id=<?php echo $lines[$start]['id'] ?>"><img src="/uploads/images/products/resize_1/<?php echo $lines[$start]['logo_general'] ?>" alt="<?php echo $lines[$start]['name'] ?>" class="img-responsive"></a>
                        <div class="caption">
                            <h5 class="item-heading"><a href="/?route=products&category_id=<?php echo $lines[$start]['parent_id'] ?>&id=<?php echo $lines[$start]['id'] ?>"><?php echo $lines[$start]['name'] ?></a></h5>
                            <div class="item-text">
                                <?php if ($manufacturer != NULL && $manufacturer != FALSE) { ?>
                                    <label><?php echo lang('product_manufacturer') ?></label> <?php echo $manufacturer ?><br />
                                <?php } if ($lines[$start]['model'] != NULL && $lines[$start]['model'] != FALSE) { ?>
                                    <label><?php echo lang('product_model') ?></label> 
                                    <?php echo $lines[$start]['model'] ?><br />
                                <?php } ?>
                                <label><?php echo lang('product_availability') ?></label>
                                <?php echo \eMarket\Products::inStock($lines[$start]['date_available'], $lines[$start]['quantity']); ?>
                            </div>
			    <div class="item-price"><label><?php echo lang('listing_price') ?></label> <?php echo \eMarket\Ecb::priceInterface($lines[$start], 1) ?></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row button">
                            <div class="col-xs-12">
				<div class="block-button">
				    <button class="btn btn-primary" type="button" onclick="ProductsListing.pcsProduct('minus', <?php echo $lines[$start]['id'] ?>)"><span class="glyphicon glyphicon-minus"></span></button>
                                    <input id="number_<?php echo $lines[$start]['id'] ?>" data-placement="top" data-content="<?php echo lang('listing_no_more_in_stock') ?>" type="number" min="1" value="<?php echo \eMarket\Cart::maxQuantityToOrder($lines[$start]) ?>" class="quantity" disabled>
				    <button class="btn btn-primary button-plus" type="button" onclick="ProductsListing.pcsProduct('plus', <?php echo $lines[$start]['id'] ?>, <?php echo \eMarket\Cart::maxQuantityToOrder($lines[$start], 'true') ?>)"><span class="glyphicon glyphicon-plus"></span></button>
				    <button class="btn btn-primary buy-now" onclick="ProductsListing.addToCart(<?php echo $lines[$start]['id'] ?>, $('#number_<?php echo $lines[$start]['id'] ?>').val())"><?php echo lang('buy_now') ?></button>
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
                 data-prev='<?php echo $navigate[0] ?>'
                 data-next='<?php echo $navigate[1] ?>'
                 data-sortflag='<?php echo $sort_flag ?>'
                 ></div>
            <div class="result-inner btn-group"><?php echo lang('with') ?> <?php echo $navigate[0] + 1 ?> <?php echo lang('to') ?> <?php echo $navigate[1] ?> ( <?php echo lang('of') ?> <?php echo $count_lines ?> )</div>

            <div class="btn-group pull-right navigate-normal" role="group">
                <?php if ($navigate[0] > 0) { ?> 
                    <button id="prev" type="button" class="btn btn-default navigation"><span aria-hidden="true">&larr;</span> <?php echo lang('button_previous') ?></button> 
                <?php } else { ?> 
                    <a id="prev" class="btn btn-default disabled" role="button"><span aria-hidden="true">&larr;</span> <?php echo lang('button_previous') ?></a> 
                    <?php
                }
                if ($navigate[1] != $count_lines) {
                    ?> 
                    <button id="next" type="button" class="btn btn-default navigation"><?php echo lang('button_next') ?> <span aria-hidden="true">&rarr;</span></button> 
                <?php } else { ?> 
                    <a id="next" class="btn btn-default disabled" role="button"><?php echo lang('button_next') ?> <span aria-hidden="true">&rarr;</span></a> 
                <?php } ?>
            </div>
            <div class="btn-group pull-right navigate-mini" role="group">
                <?php if ($navigate[0] > 0) { ?> 
                    <button id="prev" type="button" class="btn btn-default navigation"><span aria-hidden="true">&larr;</span></button> 
                <?php } else { ?> 
                    <a id="prev" class="btn btn-default disabled" role="button"><span aria-hidden="true">&larr;</span></a> 
                    <?php
                }
                if ($navigate[1] != $count_lines) {
                    ?> 
                    <button id="next" type="button" class="btn btn-default navigation"><span aria-hidden="true">&rarr;</span></button> 
                <?php } else { ?> 
                    <a id="next" class="btn btn-default disabled" role="button"><span aria-hidden="true">&rarr;</span></a> 
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
