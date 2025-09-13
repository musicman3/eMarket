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
        <div class="row">
            <?php
            foreach (Categories::$listing_data as $value) {
                if ($value[2] == true) {
                    ?>
                    <div class="mb-3 col-xl-3 col-lg-4 col-md-6 col-12">
                        <div class="card border rounded p-2 h-100">

                            <div id="image" class="h-100">
                                <a href="/?route=listing&category_id=<?php echo $value[0] ?>"><img src="/uploads/images/categories/resize_0/<?php echo $value[2] ?>" alt="<?php echo $value[1] ?>" class="img-fluid rounded mx-auto d-block"></a>
                            </div>

                            <h5 class="text-center"><a href="/?route=listing&category_id=<?php echo $value[0] ?>"><?php echo $value[1] ?></a></h5>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>  
        </div>
    </div>
    <?php
}