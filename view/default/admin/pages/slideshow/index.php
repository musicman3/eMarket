<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Настройки" -->
<?php require_once('modal/settings.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить" -->

<!-- Модальное окно "Добавить" -->
<?php require_once('modal/index.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить" -->

<div id="ajax">
    <div id="slideshow" class="container-fluid">
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
                <div id="ajax_data" class='hidden' data-jsonsettings='<?php echo $settings ?>'></div>
                
		<div class="pull-right slide-sett"><a href="#settings" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-cog"></span></a></div>
                <!-- Языковые панели -->
                <?php require_once(ROOT . '/view/' . \eMarket\Set::template() . '/layouts/lang_tabs_add.php') ?>
                <div class="tab-content">
                    <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade in active">
			<div class="table-responsive">
			    <table class="table table-hover">
				<thead>
				    <tr>
					<th colspan="4">
					    с 1 по 1 ( из 1 )
					</th>

					<th>
					    <div class="flexbox">

						<div class="b-left"><a href="#index" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>

						<form>
						    <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
						</form>

						<form>
						    <div><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
						</form>

					    </div>
					</th>

				    </tr>

				    <tr class="border">
					<th>Рисунок</th>
					<th class="text-center">Название</th>
					<th class="text-center">Начало показа</th>
					<th class="text-center">Конец показа</th>
					<th></th>
				    </tr>
				</thead>

				<tbody>
				    <tr>
					<td>Рисунок</td>
					<td class="text-center">Название</td>
					<td class="text-center">10.10.20</td>
					<td class="text-center">20.10.20</td>
					<td>
					    <div class="flexbox">
						<div class="b-left">
						    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-edit"></span></button>
						</div>
						<div>
						    <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
						</div>
					    </div>
					</td>
				    </tr>
				</tbody>
			    </table>
                        </div>
                    </div>

                    <?php
                    if ($LANG_COUNT > 1) {
                        for ($x = 1; $x < $LANG_COUNT; $x++) {
                            ?>

                            <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
				<div class="table-responsive">
				    <table class="table table-hover">

					<thead>
					    <tr>
						<th colspan="4">
						    с 1 по 1 ( из 1 )
						</th>

						<th>
						    <div class="flexbox">
							<div class="b-left"><a href="#index" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>

							<form>
							    <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
							</form>

							<form>
							    <div><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
							</form>

						    </div>
						</th>
					    </tr>

					    <tr class="border">
						<th>Рисунок</th>
						<th class="text-center">Название</th>
						<th class="text-center">Начало показа</th>
						<th class="text-center">Конец показа</th>
						<th></th>
					    </tr>
					</thead>

					<tbody>
					    <tr>
						<td>Рисунок</td>
						<td class="text-center">Название</td>
						<td class="text-center">10.10.20</td>
						<td class="text-center">20.10.20</td>
						<td>
						    <div class="flexbox">
							<div class="b-left">
							    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-edit"></span></button>
							</div>
							<div>
							    <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
							</div>
						    </div>
						</td>
					    </tr>
					</tbody>
				    </table>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
