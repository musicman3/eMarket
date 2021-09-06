<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Ecb,
    Products,
};

Products::newProducts(8);

if (Products::$new_products == true) {
    ?>
    <div id="new_products" class="contentText">
        <h3><?php echo lang('new_products_name') ?></h3>
        <div class="row">
            <?php foreach (Products::$new_products as $value) {
                ?>
                <div class="mb-3 col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="card border rounded p-2 h-100">
                        <div class="labelsblock">
                            <?php foreach (Products::stickers($value, 'bg-danger', 'bg-success') as $sticker) { ?>
                                <div class="<?php echo $sticker[0] ?>"><?php echo $sticker[1] ?></div>
                            <?php } ?>
                        </div>
                        <div id="image" class="h-100">
                            <a href="/?route=products&category_id=<?php echo $value['parent_id'] ?>&id=<?php echo $value['id'] ?>"><img src="/uploads/images/products/resize_1/<?php echo $value['logo_general'] ?>" alt="<?php echo $value['name']; ?>" class="img-fluid rounded mx-auto d-block mb-2"></a>
                        </div>
                        <div class="align-bottom">
                            <h5 class="text-center"><a href="/?route=products&category_id=<?php echo $value['parent_id'] ?>&id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></h5>
                            <div class="text-center item-price"><?php echo Ecb::priceInterface($value, 2) ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
}