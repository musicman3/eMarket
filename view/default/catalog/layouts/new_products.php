<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<?php if ($products_new == true) { ?>
    <div id="new_products" class="contentText">
        <h4><?php echo lang('new_products_name') ?></h4>
        <div class="row">
            <?php foreach ($products_new as $value) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item">
                    <div class="productHolder">
                        <a href="/?route=products&id=<?php echo $value['id']; ?>"><img src="/uploads/images/products/resize_1/<?php echo $value['logo_general']; ?>" alt="<?php echo $value['name']; ?>" class="img-responsive center-block"></a>
                        <h5 class="text-center grid-item-heading"><a href="/?route=products&id=<?php echo $value['id']; ?>"><?php echo $value['name']; ?></a></h5>
                        <div class="clearfix"></div>
                        <div class="row button">
                            <div class="col-xs-6"><button type="button" class="btn btn-default"><?php echo $PRODUCTS->productPrice($value['price'], $CURRENCIES, 1) ?></button></div>

                            <div class="col-xs-6 text-right">
                                <form id="form_add_to_cart" name="form_add_to_cart" action="javascript:void(null);" onsubmit="addToCart(<?php echo $value['id'] ?>)">
                                    <button type="submit" class="btn btn-primary"><?php echo lang('buy_now') ?></button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
}

$AJAX->сart('');

?>
<script type="text/javascript" language="javascript">
    $(window).load(function () {
        $(".grid-item-heading").simpleEQH();
    });
</script>