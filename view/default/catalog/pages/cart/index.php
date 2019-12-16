<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<h1><?php echo lang('shopping_cart') ?></h1>
<?php if ($cart_info == true) { ?>
    <div id="cart" class="contentText">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <?php foreach ($cart_info as $value) { ?>
                        <tr>
                            <td class="text-center"><a href="/?route=products&id=<?php echo $value['id'] ?>"><img src="/uploads/images/products/resize_0/<?php echo $value['logo_general'] ?>" alt="<?php echo $value['name'] ?>" class="img-thumbnail"></a></td>
                            <td class="text-left"><a href="/?route=products&id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></td>
                            <td class="text-left">Цена</td>
                            <td class="text-left">
                                <form id="quantity_product" name="quantity_product" action="javascript:void(null);" onsubmit="quantityProduct(<?php echo $value['id'] ?>, $('#number_<?php echo $value['id'] ?>').val())">
                                    <button class="btn btn-primary btn-sm" type="button" onclick="pcsProduct('minus', <?php echo $value['id'] ?>)"><span class="glyphicon glyphicon-minus"></span></button>
                                    <input id="number_<?php echo $value['id'] ?>" type="number" min="1" value="<?php echo \eMarket\Cart::productQuantity($value['id']) ?>" class="quantity">
                                    <button class="btn btn-primary btn-sm" type="button" onclick="pcsProduct('plus', <?php echo $value['id'] ?>)"><span class="glyphicon glyphicon-plus"></span></button>
                                    <button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-refresh"></span></button>
                                    <button class="btn btn-primary btn-sm" type="button" onclick="deleteProduct(<?php echo $value['id'] ?>)"><span class="glyphicon glyphicon-trash"></span></button>
                                </form>
                            </td>
                            <td class="text-right"><?php echo \eMarket\Ecb::priceCartInterface($value, $CURRENCIES, 1) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
<!--        <div id="accordion" class="panel-group">
	    <div class="panel panel-default">
		<div class="panel-heading">
		    <h6 class="panel-title"><a data-parent="#accordion" data-toggle="collapse" class="accordion-toggle" href="#collapse-voucher">Подарочный сертификат <span class="glyphicon glyphicon-triangle-bottom"></span></a></h6>
		</div>
		<div class="panel-collapse collapse" id="collapse-voucher">
		    <div class="panel-body">
			<div class="input-group">
			    <input type="text" class="form-control" id="input-voucher" placeholder="Введите № сертификата" value="" name="voucher">
			    <span class="input-group-btn">
				<input type="submit" class="btn btn-primary" data-loading-text="Loading..." id="button-voucher" value="Применить">
			    </span>
			</div>
		    </div>
		</div>
	    </div>
	    <div class="panel panel-default">
		<div class="panel-heading">
		    <h6 class="panel-title"><a data-parent="#accordion" data-toggle="collapse" class="accordion-toggle" href="#collapse-coupon">Дисконтная карта <span class="glyphicon glyphicon-triangle-bottom"></span></a></h6>
		</div>
		<div class="panel-collapse collapse" id="collapse-coupon">
		    <div class="panel-body">
			<div class="input-group">
			    <input type="text" class="form-control" id="input-coupon" placeholder="Введиде № карты" value="" name="coupon">
			    <span class="input-group-btn">
				<input type="button" class="btn btn-primary" data-loading-text="Loading..." id="button-coupon" value="Применить">
			    </span>
			</div>
		    </div>
		</div>
	    </div>
        </div>-->
        
	<div class="input-group">
	    <input type="text" class="form-control" id="input-coupon" placeholder="Введиде № подарочного сертификата" value="" name="coupon">
	    <span class="input-group-btn">
		<input type="button" class="btn btn-primary" data-loading-text="Loading..." id="button-voucher" value="Применить">
	    </span>
	</div><br/>

	<div class="input-group">
	    <input type="text" class="form-control" id="input-coupon" placeholder="Введиде № дисконтной карты" value="" name="coupon">
	    <span class="input-group-btn">
		<input type="button" class="btn btn-primary" data-loading-text="Loading..." id="button-coupon" value="Применить">
	    </span>
	</div><br/>

        <div class="row">
            <div class="col-sm-4 col-sm-offset-8">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-right"><strong><?php echo lang('total') ?>:</strong></td>
                            <td class="text-right"><?php echo \eMarket\Ecb::totalPriceCartInterface($CURRENCIES, 1) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div id="accordions" class="panel-group">
	    <div class="panel panel-default">
		<div class="panel-heading">
		    <h6 class="panel-title"><a data-parent="#accordions" data-toggle="collapse" class="accordion-toggle" href="#collapse-devilery">Способ доставки <span class="glyphicon glyphicon-triangle-bottom"></span></a></h6>
		</div>
		<div class="panel-collapse collapse" id="collapse-devilery">
		    <div class="panel-body">
			<div class="form-check">
			    <input class="form-check-input" type="radio">
			    <label class="form-check-label">Энергия</label>
			</div>
		    </div>
		</div>
	    </div>
	    <div class="panel panel-default">
		<div class="panel-heading">
		    <h6 class="panel-title"><a data-parent="#accordions" data-toggle="collapse" class="accordion-toggle" href="#collapse-checkout">Способ оплаты <span class="glyphicon glyphicon-triangle-bottom"></span></a></h6>
		</div>
		<div class="panel-collapse collapse" id="collapse-checkout">
		    <div class="panel-body">
			<div class="form-check">
			    <input class="form-check-input" type="radio">
			    <label class="form-check-label">В пункте самовывоза</label>
			</div>
		    </div>
		</div>
	    </div>
        </div>
        
        <div class="input-group-btn button">
            <div class="pull-left"><a class="btn btn-primary" href="/"><?php echo lang('сheckout_click') ?></a></div>
            <div class="pull-right"><a class="btn btn-primary" href="/"><?php echo lang('сheckout') ?></a></div>
        </div>
    </div>
<?php } else { ?>
    <div id="cart" class="contentText">
        <div class="well well-sm">
            <div class="btn-group">
                <div class="btn"><?php echo lang('shopping_cart_empty') ?></div>
            </div>
        </div>
    </div>
<?php } ?>