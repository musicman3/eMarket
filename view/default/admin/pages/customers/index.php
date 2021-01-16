<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div id="customers">
    <div class="panel panel-default">
	<div class="panel-heading">
	    <!--Выводим уведомление об успешном действии-->
	    <div id="alert_block"><?php \eMarket\Core\Messages::alert(); ?></div>
	    <h3 class="panel-title">
		<?php echo \eMarket\Core\Settings::titlePageGenerator() ?>
	    </h3>
	</div>
	<div class="panel-body">

	    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 offset-0">
		<form>
		    <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
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
			    <th colspan="4"><?php echo \eMarket\Core\Pages::counterPage() ?></th>

			    <th>
				<div class="flexbox">
				    <form>
					<input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
					<input hidden name="backstart" value="<?php echo \eMarket\Core\Pages::$start ?>">
					<input hidden name="backfinish" value="<?php echo \eMarket\Core\Pages::$finish ?>">
					<div class="b-left">
					    <?php if (\eMarket\Core\Pages::$start > 0) { ?>
    					    <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button>
					    <?php } else { ?>
    					    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-left"></span></a>
					    <?php } ?>
					</div>
				    </form>
				    <form>
					<input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
					<input hidden name="start" value="<?php echo \eMarket\Core\Pages::$start ?>">
					<input hidden name="finish" value="<?php echo \eMarket\Core\Pages::$finish ?>">
					<div>
					    <?php if (\eMarket\Core\Pages::$finish != \eMarket\Core\Pages::$count) { ?>
    					    <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button>
					    <?php } else { ?>
    					    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-right"></span></a>
					    <?php } ?>
					</div>
				    </form>
				</div>
			    </th>
			</tr>
			<?php if (\eMarket\Core\Pages::$finish > 0) { ?>
    			<tr class="border">
    			    <th><?php echo lang('customers_firstname') ?></th>
    			    <th class="text-center"><?php echo lang('customers_lastname') ?></th>
    			    <th class="text-center"><?php echo lang('customers_date_created') ?></th>
    			    <th class="text-center"><?php echo lang('customers_email') ?></th>
    			    <th></th>
    			</tr>
			<?php } ?>
		    </thead>
		    <tbody>
			<?php for (\eMarket\Core\Pages::$start; \eMarket\Core\Pages::$start < \eMarket\Core\Pages::$finish; \eMarket\Core\Pages::$start++, \eMarket\Core\Pages::lineUpdate()) { ?>
    			<tr class="<?php echo \eMarket\Core\Settings::statusSwitchClass(\eMarket\Core\Pages::$table['line'][18]) ?>">
    			    <td><?php echo \eMarket\Core\Pages::$table['line'][3] ?></td>
    			    <td class="text-center"><?php echo \eMarket\Core\Pages::$table['line'][4] ?></td>
    			    <td class="text-center"><?php echo \eMarket\Core\Settings::dateLocale(\eMarket\Core\Pages::$table['line'][6]) ?></td>
    			    <td class="text-center"><?php echo \eMarket\Core\Pages::$table['line'][11] ?></td>
    			    <td>
    				<div class="flexbox">
    				    <!--Кнопка переключения статуса-->
    				    <form id="form_status<?php echo \eMarket\Core\Pages::$table['line'][0] ?>" name="form_status" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_status<?php echo \eMarket\Core\Pages::$table['line'][0] ?>')" enctype="multipart/form-data">
    					<input hidden name="status" value="<?php echo \eMarket\Core\Pages::$table['line'][0] ?>">
    					<div class="b-left">
    					    <button type="submit" name="status_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-status') ?>"><span class="glyphicon glyphicon-off"> </span></button>
    					</div>
    				    </form>
    				    <form id="form_delete<?php echo \eMarket\Core\Pages::$table['line'][0] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo \eMarket\Core\Pages::$table['line'][0] ?>')" enctype="multipart/form-data">
    					<input hidden name="delete" value="<?php echo \eMarket\Core\Pages::$table['line'][0] ?>">
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