<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<?php if ($categories == true) { ?>
<div class="contentText">
    <h4>Categories</h4>
    <div id="categories_listing" class="row grid-group">

        <?php foreach ($categories as $value) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item">
                <div class="categoriesHolder">
                    <?php if ($value[2] == true) { ?>
                    <a href="/?route=listing&category_id=<?php echo $value[0] ?>&parent_id=<?php echo $VALID->inGET('category_id') ?>"><img src="/uploads/images/categories/resize_0/<?php echo $value[2] ?>" class="img-responsive img-rounded center-block"></a>
                    <?php } ?>
                    <h5 class="text-center"><a href="/?route=listing&category_id=<?php echo $value[0] ?>&parent_id=<?php echo $VALID->inGET('category_id') ?>"><?php echo $value[1] ?></a></h5>
                </div>
            </div>
        <?php } ?>  
    </div>
</div>
<?php } ?>