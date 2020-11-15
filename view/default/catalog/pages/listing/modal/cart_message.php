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
                <h4 id="confirm_title" class="modal-title">Product successfully added to your shopping cart</h4>
            </div>
	    <div class="modal-body">
		<div class="row">
		    <div id="product_image" class="col-xs-5"></div>
		    <div class="col-xs-7">
			<p><strong>Товар:</strong>&nbsp;<span id="product_name"></span></p>
			<p><strong>Цена:</strong>&nbsp;<span id="product_price_formated"></span></p>
			<p><strong>Количество:</strong>&nbsp;<span id="product_quantity"></span></p>
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