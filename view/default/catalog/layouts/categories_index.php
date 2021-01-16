<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
\eMarket\Catalog\Categories::indexData();
?>

<?php if (\eMarket\Catalog\Categories::$index_data == true) { ?>
<div id="categories_index" class="contentText">
    <h3><?php echo lang('categories_name') ?></h3>
    <div class="row grid-group">
        <?php foreach (\eMarket\Catalog\Categories::$index_data as $value) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item">
                <div class="categoriesHolder">
                    <?php if ($value[2] == true) { ?>
                    <a href="/?route=listing&category_id=<?php echo $value[0] ?>"><img src="/uploads/images/categories/resize_0/<?php echo $value[2] ?>" alt="<?php echo $value[1] ?>" class="img-responsive img-rounded center-block"></a>
                    <?php } ?>
                    <h5 class="text-center"><a href="/?route=listing&category_id=<?php echo $value[0] ?>"><?php echo $value[1] ?></a></h5>
                </div>
            </div>
        <?php } ?>  
    </div>
</div>
<?php } ?>