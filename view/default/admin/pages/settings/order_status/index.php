<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно -->
<?php require_once('modal/index.php') ?>
<!-- КОНЕЦ Модальное окно -->

<div id="settings_order_status">
    <div class="panel panel-default">
	<div class="panel-heading">
	    <!--Выводим уведомление об успешном действии-->
	    <div id="alert_block"><?php \eMarket\Messages::alert(); ?></div>
	    <h3 class="panel-title">
		<span class="settings_back"><button type="button" onClick='location.href = "<?php echo \eMarket\Set::parentPartitionGenerator() ?>"' class="btn btn-primary btn-xs"><span class="back glyphicon glyphicon-share-alt"></span></button></span><span class="settings_name"><?php echo \eMarket\Set::titlePageGenerator() ?></span>
	    </h3>
	</div>
	<div class="panel-body">
	    <!--Скрытый div для передачи данных-->
	    <div id="ajax_data" class='hidden' data-jsondata='<?php echo $json_data ?>'></div>

	    <div class="table-responsive">
		<table class="table table-hover">
		    <thead>
			<tr>
			    <th colspan="3">
				<?php if ($lines == TRUE) { ?>
				    <?php echo lang('with') ?> <?php echo $start + 1 ?> <?php echo lang('to') ?> <?php echo $finish ?> ( <?php echo lang('of') ?> <?php echo $count_lines; ?> )
				    <?php
				} else {
				    ?>
				    <?php echo lang('no_listing') ?>
				<?php } ?>
			    </th>

			    <th>
				<div class="flexbox">
				    <div class="b-left"><a href="#index" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>
				    <form>
					<input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
					<input hidden name="backstart" value="<?php echo $start ?>">
					<input hidden name="backfinish" value="<?php echo $finish ?>">
					<div class="b-left">
					    <?php if ($start > 0) { ?>
    					    <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button>
					    <?php } else { ?>
    					    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-left"></span></a>
					    <?php } ?>
					</div>
				    </form>
				    <form>
					<input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
					<input hidden name="start" value="<?php echo $start ?>">
					<input hidden name="finish" value="<?php echo $finish ?>">
					<div>
					    <?php if ($finish != $count_lines) { ?>
    					    <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button>
					    <?php } else { ?>
    					    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-right"></span></a>
					    <?php } ?>
					</div>
				    </form>
				</div>
			    </th>
			</tr>
			<?php if ($lines == TRUE) { ?>
    			<tr class="border">
    			    <th class="sortleft-m"><div></div></th>
    			    <th><?php echo lang('order_status_name') ?></th>
    			    <th class="text-center"><?php echo lang('default') ?></th>
    			    <th></th>
    			</tr>
			<?php } ?>
		    </thead>
		    <tbody id="sort-list">
			<?php for ($start; $start < $finish; $start++) { ?>
    			<tr class="sort-list" unitid="<?php echo $lines[$start]['id'] ?>">
    			    <td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td> 
    			    <td><?php echo $lines[$start]['name'] ?></td>
				<?php if ($lines[$start]['default_order_status'] == 1) { ?>
				    <td class="text-center"><?php echo lang('confirm-yes') ?></td>
				<?php } else { ?>
				    <td class="text-center"><?php echo lang('confirm-no') ?></td>
				<?php } ?>
    			    <td>
    				<div class="flexbox">
    				    <!--Вызов модального окна для редактирования-->
    				    <div class="b-left">
    					<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#index" data-edit="<?php echo $lines[$start]['id'] ?>"><span class="glyphicon glyphicon-edit"></span></button>
    				    </div>
    				    <form id="form_delete<?php echo $lines[$start]['id'] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo $lines[$start]['id'] ?>')" enctype="multipart/form-data">
    					<input hidden name="delete" value="<?php echo $lines[$start]['id'] ?>">
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