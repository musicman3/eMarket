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
        <div class="row row-cols-1 row-cols-md-4 g-0">
            <?php foreach (Products::$new_products as $value) {
                ?>
                <div class="col g-3">
                    <div class="card h-100 border rounded p-2">
                        <div class="labelsblock">
                            <?php foreach (Products::stikers($value, 'bg-danger', 'bg-success') as $stiker) { ?>
                                <div class="<?php echo $stiker[0] ?>"><?php echo $stiker[1] ?></div>
                            <?php } ?>
                        </div>
                        <div class="col h-100">
                            <a href="/?route=products&category_id=<?php echo $value['parent_id'] ?>&id=<?php echo $value['id'] ?>"><img src="/uploads/images/products/resize_1/<?php echo $value['logo_general'] ?>" alt="<?php echo $value['name']; ?>" class="img-fluid rounded mx-auto d-block mb-2"></a>
                        </div>
                        <div class="col h-100 text-center">
                            <h5><a href="/?route=products&category_id=<?php echo $value['parent_id'] ?>&id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></h5>
                            <div class="item-price"><?php echo Ecb::priceInterface($value, 2) ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
}