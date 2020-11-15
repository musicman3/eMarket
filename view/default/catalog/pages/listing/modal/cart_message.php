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
            <div class="modal-header"><div class="pull-right">&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 id="confirm_title" class="modal-title">Product successfully added to your shopping cart</h4>
            </div>
	    <div class="modal-body">
		<div class="row">
		    <div class="col-md-5">
			<div class="row">
			    <div id="product_image" class="col-md-6"></div>
			    <div>
				<span>Товар:&nbsp;<strong id="product_name"></strong></span>
				<span>Цена:&nbsp;<strong id="product_price_formated"></strong></span>
				<span>Количество:&nbsp;<strong id="product_quantity"></strong></span>
			    </div>
			</div>
		    </div>
		</div>
	    </div>
            <div class="modal-footer">
		<button type="submit" class="btn btn-primary" data-dismiss="modal">Продолжить покупки</button> <button type="submit" class="btn btn-success" onClick='location.href="/?route=cart"'>Перейти к оформлению</button>
	    </div>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно "Добавить категорию" -->