<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Модальное окно "Добавить категорию" -->
<div id="cart_message" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="confirm_title" class="modal-title text-center"><?php echo lang('listing_product_added_to_cart') ?></h4>
            </div>
	    <div class="modal-body">
		<div class="row">
		    <div id="product_image" class="col-xs-5"></div>
		    <div class="col-xs-7">
			<p><strong><?php echo lang('listing_product') ?></strong>&nbsp;<span id="product_name"></span></p>
			<p><strong><?php echo lang('listing_price') ?></strong>&nbsp;<span id="product_price_formated"></span></p>
			<p><strong><?php echo lang('listing_quantity') ?></strong>&nbsp;<span id="product_quantity"></span></p>
		    </div>
		</div>
	    </div>
            <div class="modal-footer">
		<button type="submit" class="btn btn-primary" data-dismiss="modal"><?php echo lang('button_continue_shopping') ?></button> <button type="submit" class="btn btn-success" onClick='location.href="/?route=cart"'><?php echo lang('button_proceed_to_checkout') ?></button>
	    </div>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно "Добавить категорию" -->