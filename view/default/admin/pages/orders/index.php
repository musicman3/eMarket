<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Модальное окно -->
<?php require_once('modal/index.php') ?>
<!-- КОНЕЦ Модальное окно -->

<div id="ajax">
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <!--Выводим уведомление об успешном действии-->
                <?php \eMarket\Messages::alert(); ?>
                <h3 class="panel-title">
                    <?php echo \eMarket\Set::titlePageGenerator() ?>
                </h3>
            </div>
            <div class="panel-body">
                <!--Скрытый div для передачи данных-->
                <div id="ajax_data" class='hidden' data-orders='<?php echo $json_data ?>'></div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 offset-0">
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
				<th colspan="7">
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
			    <?php for ($start; $start < $finish; $start++) { ?>
				<tr>
				    <td><?php echo $lines[$start][0] ?></td>
				    <td class="text-center"><?php echo json_decode($lines[$start][2], 1)['firstname'] . ' ' . json_decode($lines[$start][2], 1)['lastname'] ?></td>
				    <td class="text-center"><?php echo $lines[$start][1] ?></td>
				    <td class="text-center"><?php echo json_decode($lines[$start][5], 1)['admin']['total_format'] ?></td>
				    <td class="text-center"><?php echo \eMarket\Set::dateLocale($lines[$start][12], '%c') ?></td>
				    <td class="text-center"><?php echo \eMarket\Set::dateLocale($lines[$start][11], '%c') ?></td>
				    <td class="text-center"><?php echo json_decode($lines[$start][3], 1)[0]['admin']['status'] ?></td>
				    <td>
					<div class="flexbox">
					    <!--Вызов модального окна для редактирования-->
					    <div class="b-left">
						<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#index" data-edit="<?php echo $lines[$start][0] ?>"><span class="glyphicon glyphicon-edit"></span></button>
					    </div>
					    <form id="form_delete<?php echo $lines[$start][0] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo $lines[$start][0] ?>')" enctype="multipart/form-data">
						<input hidden name="delete" value="<?php echo $lines[$start][0] ?>">
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
</div>
