<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<!-- Модальное окно -->
<?php require_once('modal/index.php') ?>
<!-- КОНЕЦ Модальное окно -->

<div id="orders">
    <div class="panel panel-default">
	<div class="panel-heading">
	    <!--Выводим уведомление об успешном действии-->
	    <div id="alert_block"><?php \eMarket\Messages::alert(); ?></div>
	    <h3 class="panel-title">
		<?php echo \eMarket\Settings::titlePageGenerator() ?>
	    </h3>
	</div>
	<div class="panel-body">
	    <!--Скрытый div для передачи данных-->
            <div id="ajax_data" class='hidden' data-orders='<?php echo \eMarket\Admin\Orders::$json_data ?>'></div>

	    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 offset-0">
		<form>
		    <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
		    <div class="input-group">
			<input type="search" id="search" name="search" placeholder="<?php echo lang('search') ?>" class="form-control">
			<span class="input-group-btn">
			    <button type="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-search"></span>
			    </button>
			</span>
		    </div>
		</form>
	    </div>
	    <div class="clearfix"></div>
	    <div class="table-responsive">
		<table class="table table-hover">
		    <thead>
			<tr>
			    <th colspan="7"><?php echo \eMarket\Pages::counterPage() ?></th>

			    <th>
				<div class="flexbox">
				    <form>
					<input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
					<input hidden name="backstart" value="<?php echo \eMarket\Pages::$start ?>">
					<input hidden name="backfinish" value="<?php echo \eMarket\Pages::$finish ?>">
					<div class="b-left">
					    <?php if (\eMarket\Pages::$start > 0) { ?>
    					    <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button>
					    <?php } else { ?>
    					    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-left"></span></a>
					    <?php } ?>
					</div>
				    </form>
				    <form>
					<input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
					<input hidden name="start" value="<?php echo \eMarket\Pages::$start ?>">
					<input hidden name="finish" value="<?php echo \eMarket\Pages::$finish ?>">
					<div>
					    <?php if (\eMarket\Pages::$finish != \eMarket\Pages::$count) { ?>
    					    <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button>
					    <?php } else { ?>
    					    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-right"></span></a>
					    <?php } ?>
					</div>
				    </form>
				</div>
			    </th>
			</tr>
			<?php if (\eMarket\Pages::$count > 0) { ?>
    			<tr class="border">
    			    <th><?php echo lang('orders_number') ?></th>
    			    <th class="text-center"><?php echo lang('orders_client') ?></th>
    			    <th class="text-center"><?php echo lang('orders_email') ?></th>
    			    <th class="text-center"><?php echo lang('orders_total') ?></th>
    			    <th class="text-center"><?php echo lang('orders_date_added') ?></th>
    			    <th class="text-center"><?php echo lang('orders_date_of_change') ?></th>
    			    <th class="text-center"><?php echo lang('orders_status') ?></th>
    			    <th></th>
    			</tr>
			<?php } ?>
		    </thead>
		    <tbody>
			<?php for (\eMarket\Pages::$start; \eMarket\Pages::$start < \eMarket\Pages::$finish; \eMarket\Pages::$start++, \eMarket\Pages::lineUpdate()) { ?>
    			<tr>
    			    <td><?php echo eMarket\Pages::$table['line']['id'] ?></td>
    			    <td class="text-center"><?php echo json_decode(eMarket\Pages::$table['line']['customer_data'], 1)['firstname'] . ' ' . json_decode(eMarket\Pages::$table['line']['customer_data'], 1)['lastname'] ?></td>
    			    <td class="text-center"><?php echo eMarket\Pages::$table['line']['email'] ?></td>
    			    <td class="text-center"><?php echo json_decode(eMarket\Pages::$table['line']['order_total'], 1)['admin']['total_to_pay_format'] ?></td>
    			    <td class="text-center"><?php echo \eMarket\Settings::dateLocale(eMarket\Pages::$table['line']['date_purchased'], '%c') ?></td>
    			    <td class="text-center"><?php echo \eMarket\Settings::dateLocale(eMarket\Pages::$table['line']['last_modified'], '%c') ?></td>
    			    <td class="text-center"><?php echo json_decode(eMarket\Pages::$table['line']['orders_status_history'], 1)[0]['admin']['status'] ?></td>
    			    <td>
    				<div class="flexbox">
    				    <!--Вызов модального окна для редактирования-->
    				    <div class="b-left">
    					<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#index" data-edit="<?php echo eMarket\Pages::$table['line']['id'] ?>"><span class="glyphicon glyphicon-edit"></span></button>
    				    </div>
    				    <form id="form_delete<?php echo eMarket\Pages::$table['line']['id'] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo eMarket\Pages::$table['line']['id'] ?>')" enctype="multipart/form-data">
    					<input hidden name="delete" value="<?php echo eMarket\Pages::$table['line']['id'] ?>">
    					<div>
    					    <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
    					</div>
    				    </form>
    				</div>
    			    </td>
    			</tr>
			<?php } ?>
		    </tbody>
		</table>
	    </div>
	</div>
    </div>
</div>