<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="settings_basic_settings" class="container-fluid">
    <div class="panel panel-default">

        <div class="panel-heading">
            <!--Выводим уведомление об успешном действии-->
            <?php $MESSAGES->alert(); ?>
            <h3 class="panel-title">
                <div class="pull-left"><a class="btn btn-primary btn-xs" href="?route=settings"><span class="back glyphicon glyphicon-share-alt"></span></a> <?php echo lang('title_' . $SET->titleDir() . '_index') ?></div>
                <div class="clearfix"></div>
            </h3>
        </div>
        <div class="panel-body">
            <!-- Панели -->
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#payment_modules"><?php echo lang('payment_modules') ?></a></li>
                <li><a data-toggle="tab" href="#shipping_modules"><?php echo lang('shipping_modules') ?></a></li>
                <li><a data-toggle="tab" href="#cart_modules"><?php echo lang('cart_modules') ?></a></li>
                <li><a data-toggle="tab" href="#other_modules"><?php echo lang('other_modules') ?></a></li>
            </ul>

	    <!-- Содержимое панелей -->
	    <div class="tab-content">
		<!-- Оплата -->
		<div id="payment_modules" class="tab-pane fade in active">

                    
                    
                    
		</div>
		<!-- Доставка -->
		<div id="shipping_modules" class="tab-pane fade">
		    
                    
                    

		</div>
                
                <!-- Корзина -->
		<div id="cart_modules" class="tab-pane fade">
		    
                    
                    

		</div>
                
                <!-- Другое -->
		<div id="other_modules" class="tab-pane fade">
		    
                    
                    

		</div>
	    </div>        
	</div>
    </div>
</div>