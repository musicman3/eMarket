<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<script type="text/javascript" language="javascript">
    $(window).load(function () {
        $(".grid-item-heading").simpleEQH();
    });
</script>

<?php if ($products_new == true) { ?>
    <div id="new_products" class="contentText">
        <h4><?php echo lang('new_products_name') ?></h4>
        <div class="row">
            <?php foreach ($products_new as $value) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item">
                    <div class="productHolder">
                        <a href="/?route=products&id=<?php echo $value[0]; ?>"><img src="/uploads/images/products/resize_1/<?php echo $value[7]; ?>" class="img-responsive center-block"></a>
                        <h5 class="text-center grid-item-heading"><a href="/?route=products&id=<?php echo $value[0]; ?>"><?php echo $value[1]; ?></a></h5>
                        <div class="clearfix"></div>
                        <div class="row button">
                            <div class="col-xs-6"><button type="button" class="btn btn-default"><?php echo $PRODUCTS->productPrice($value[12], $CURRENCIES, 1) ?></button></div>
                            <div class="col-xs-6 text-right"><a id="btn1" href="/?route=catalog&add_to_cart=<?php echo $value[0]; ?>" class="btn btn-primary"><?php echo lang('buy_now') ?></a></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>