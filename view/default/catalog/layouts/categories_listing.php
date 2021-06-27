<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Catalog\Categories;

Categories::listingData();
?>

<?php if (Categories::$listing_data == true) { ?>
    <div id="categories_listing" class="contentText">
        <h3><?php echo lang('categories_name') ?></h3>
        <div class="row">
            <?php foreach (Categories::$listing_data as $value) { ?>
                <div class="mb-3 col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="border rounded p-2">
                        <?php if ($value[2] == true) { ?>
                            <a href="/?route=listing&category_id=<?php echo $value[0] ?>"><img src="/uploads/images/categories/resize_0/<?php echo $value[2] ?>" alt="<?php echo $value[1] ?>" class="img-fluid rounded mx-auto d-block"></a>
                        <?php } ?>
                        <h5 class="text-center"><a href="/?route=listing&category_id=<?php echo $value[0] ?>"><?php echo $value[1] ?></a></h5>
                    </div>
                </div>
            <?php } ?>  
        </div>
    </div>
<?php }