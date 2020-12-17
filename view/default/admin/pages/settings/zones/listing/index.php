<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Добавить" -->
<?php require_once('modal/index.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить" -->

<div id="settings_zones_listing">
    <div class="panel panel-default">
	<div class="panel-heading">
	    <!--Выводим уведомление об успешном действии-->
	    <div id="alert_block"><?php \eMarket\Messages::alert(); ?></div>
	    <h3 class="panel-title">
		<span class="settings_back"><a class="btn btn-primary btn-xs" href="<?php echo \eMarket\Settings::parentPartitionGenerator() ?>"><span class="back glyphicon glyphicon-share-alt"></span></a></span><span class="settings_name"><?php echo \eMarket\Settings::titlePageGenerator() ?></span>
	    </h3>
	</div>
	<div class="panel-body">
	    <div class="table-responsive">
		<table class="table table-hover">
		    <thead>
			<tr>
			    <th colspan="2">
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

				    <div class="b-left"><a href="#index" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-pencil"></span></a></div>

				    <form>
					<input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
					<input hidden name="backstart" value="<?php echo $start ?>">
					<input hidden name="backfinish" value="<?php echo $finish ?>">
					<input hidden name="zone_id" value="<?php echo $zones_id ?>">
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
					<input hidden name="zone_id" value="<?php echo $zones_id ?>">
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
    			    <th> </th>
    			    <th><?php echo lang('country') ?></th>
    			    <th> </th>
    			</tr>
			<?php } ?>
		    </thead>
		    <tbody>
			<?php
			$count = 0;
			for ($start; $start < $finish; $start++) {
			    ?>
    			<tr>
    			    <td class="sortleft"><span data-toggle="tooltip" data-html="true" data-placement="right" data-original-title="<?php echo $text_arr[$count] ?>" class="btn btn-primary btn-xs glyphicon glyphicon-eye-open"></span></td>
    			    <td><?php echo \eMarket\Func::filterArrayToKey($countries_multiselect_temp, 0, $lines[$start][0], 1)[0] ?></td>
    			    <td> </td>
    			</tr>
			    <?php
			    $count++;
			}
			?>
		    </tbody>
		</table>
	    </div>
	</div>
    </div>
</div>