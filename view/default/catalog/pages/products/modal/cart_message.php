<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="cart_message" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-light py-2 px-3">
                <h3 id="confirm_title" class="modal-title text-center"><?php echo lang('listing_product_added_to_cart') ?></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="product_image" class="col-5 d-flex align-items-center">
                        <img class="img-thumbnail mx-auto d-block" src="/uploads/images/products/resize_0/<?php echo \eMarket\Catalog\Products::$products['logo_general'] ?>" alt="<?php echo \eMarket\Catalog\Products::$products['name'] ?>" />
                    </div>
                    <div class="col-7 d-grid align-items-center">
                        <div><strong><?php echo lang('listing_product') ?></strong>&nbsp;<span id="product_name"><?php echo \eMarket\Catalog\Products::$products['name'] ?></span></div>
                        <div><strong><?php echo lang('listing_price') ?></strong>&nbsp;<span id="product_price_formated"><?php echo \eMarket\Core\Ecb::priceInterface(\eMarket\Catalog\Products::$products, 2) ?></span></div>
                        <div><strong><?php echo lang('listing_quantity') ?></strong>&nbsp;<span id="product_quantity"></span></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-evenly">
                <button type="submit" class="btn btn-primary btn-sm" data-bs-dismiss="modal"><?php echo lang('button_continue_shopping') ?></button> <button type="submit" class="btn btn-success btn-sm" onClick='location.href = "/?route=cart"'><?php echo lang('button_proceed_to_checkout') ?></button>
            </div>
        </div>
    </div>
</div>