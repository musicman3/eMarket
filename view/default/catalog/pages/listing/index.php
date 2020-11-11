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

<?php if (\eMarket\Valid::inGET('search')) { ?><h1><?php echo lang('listing_search'); ?></h1><?php } else { ?><h1><?php echo $categories_name ?></h1><?php } ?>

<?php if ($products == true) { ?>
    <div id="listing" class="contentText">
        <div class="well well-sm">
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Сортировать <span class="caret"></span></button>
                <ul class="dropdown-menu text-right">
                    <li><a id="default" class="sorting">По умолчанию</a></li>
                    <li><a id="name" class="sorting">По названию</a></li>
                    <li><a id="down" class="sorting">Цена (по убыванию)</a></li>
                    <li><a id="up" class="sorting">Цена (по возрастанию)</a></li>
                </ul>
                &nbsp;&nbsp;<input class="check-box" hidden type="checkbox" data-off-color="danger" data-size="normal" data-label-text="Отобразить" data-label-width='auto' data-on-text="Все" data-off-text="В наличии" data-handle-width="80" name="show_in_stock" id="show_in_stock"<?php echo $checked_stock ?>>
            </div>
            <div class="btn-group pull-right">
                <a id="grid" class="btn btn-default item-grid active"><span class="glyphicon glyphicon-th"></span></a>
                <a id="list" class="btn btn-default item-list"><span class="glyphicon glyphicon-th-list"></span></a>
            </div>
        </div>

        <div class="row">
            <?php foreach ($products as $value) { ?>
                <div class="item col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item">
                    <div class="productHolder">
                        <a href="/?route=products&category_id=<?php echo $value['parent_id'] ?>&id=<?php echo $value['id'] ?>"><img src="/uploads/images/products/resize_1/<?php echo $value['logo_general'] ?>" alt="<?php echo $value['name'] ?>" class="img-responsive"></a>
                        <div class="caption">
                            <h5 class="item-heading"><a href="/?route=products&category_id=<?php echo $value['parent_id'] ?>&id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></h5>
                            <div class="item-text"><br />
                                <label>Vendor:</label> 67788, 
                                <label><?php echo lang('product_manufacturer') ?></label> HP, 
                                <?php if ($value['model'] != NULL && $value['model'] != FALSE) { ?><label><?php echo lang('product_model') ?></label> <?php echo $value['model'] ?>,<?php } ?>
                                <label><?php echo lang('product_weight') ?></label> 20 kg, 
                                <label><?php echo sprintf(lang('product_dimension'), '') ?></label> 110/200/500 (H/L/W), 
                                <label><?php echo lang('product_availability') ?></label> In Stock
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row button">
                            <div class="col-xs-6"><?php echo \eMarket\Ecb::priceInterface($value, 1) ?></div>
                            <div class="col-xs-6 text-right">
                                <form id="form_add_to_cart" name="form_add_to_cart" action="javascript:void(null);" onsubmit="addToCart(<?php echo $value['id'] ?>, 'true')">
                                    <button type="submit" class="btn btn-primary"><?php echo lang('buy_now') ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>  
        </div>

        <div class="well well-sm">
            <div class="result-inner btn-group">Showing 1 to 8 of 10 (2 Pages)</div>
            <div class="pagination-inner pull-right">
                <ul class="pagination">
                    <li class="active"><span>1</span></li>
                    <li><a href="#">2</a></li>
                </ul>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div id="listing" class="contentText">
        <div class="well well-sm">
	    <div class="btn-group">
		<div class="btn">
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
    </div>
<?php } ?>