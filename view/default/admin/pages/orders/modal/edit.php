<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
//require(ROOT . '/controller/admin/pages/orders/modal/edit.php');
?>

<!-- Модальное окно "Изменить" -->
<div id="edit" class="products modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Ставка указывается в формате: 10.00" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Set::titlePageGenerator() ?></h4>
            </div>
            <form id="form_edit" name="form_edit" action="javascript:void(null);" onsubmit="callEdit()">
                <div class="panel-body">
                    <input id="js_edit" type="hidden" name="edit" value="" />
                    <!-- Панели формы -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#panel_edit_1">Описание</a></li>
                        <li><a data-toggle="tab" href="#panel_edit_2">Товары</a></li>
                        <li><a data-toggle="tab" href="#panel_edit_3">История транзакций</a></li>
                        <li><a data-toggle="tab" href="#panel_edit_4">История статусов</a></li>
                    </ul>
                    <!-- Содержимое панелей формы-->
                    <div class="tab-content">

                        <!-- Содержимое панели Описание -->
                        <div id="panel_edit_1" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-left form-group">
                                    <div class="label label-primary">Клиент</div>
                                    <div>
                                        <small class="form-text text-muted">
                                            Николай Пермяков
                                            Симферопольский бульвар, дом 1
                                            Москва
                                            Российская Федерация
                                        </small>
                                    </div>
                                </div>
                                <div class="col-left form-group">
                                    <div class="label label-primary">Клиент</div>
                                    <div>
                                        <small class="form-text text-muted">
                                            Николай Пермяков
                                            Симферопольский бульвар, дом 1
                                            Москва
                                            Российская Федерация
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Содержимое панели Товары -->
                        <div id="panel_edit_2" class="tab-pane fade">
			    <div class="table-responsive">

				<table class="table table-bordered">
				    <tbody>
					<tr>
					    <td class="text-center"><strong>Товар</strong></td>
					    <td class="text-center"><strong>Цена</strong></td>
					    <td class="text-center"><strong>Кол-во</strong></td>
					    <td class="text-center"><strong>Сумма</strong></td>
					</tr>
					<tr>
					    <td class="text-center">111</td>
					    <td class="text-center">222</td>
					    <td class="text-center">333</td>
					    <td class="text-center">444</td>
					</tr>
				    </tbody>
				</table>

				<table class="table table-bordered">
				    <tbody>
					<tr>
					    <td class="text-right"><strong>Стоимость:</strong></td>
					    <td class="text-right">111</td>
					</tr>
					<tr>
					    <td class="text-right"><strong>Доставка:</strong></td>
					    <td class="text-right">222</td>
					</tr>
					<tr>
					    <td class="text-right"><strong>Итого:</strong></td>
					    <td class="text-right">333</td>
					</tr>
				    </tbody>
				</table>

			    </div>
                        </div>

                        <!-- Содержимое панели История транзакций -->
                        <div id="panel_edit_3" class="tab-pane fade">
                            <div class="col-left form-group">
                                <div><small class="form-text text-muted">Значение идентификатора товара</small></div>
                                <div class="input-group has-success">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input class="input-sm form-control" placeholder="ABC125" type="text" name="vendor_code_value_product_stock_edit" id="vendor_code_value_product_stock_edit" />
                                </div>
                            </div>
                        </div>

                        <!-- Содержимое панели История статусов -->
                        <div id="panel_edit_4" class="tab-pane fade">
                            <div class="col-left form-group">
                                <div><small class="form-text text-muted">Значение идентификатора товара</small></div>
                                <div class="input-group has-success">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input class="input-sm form-control" placeholder="ABC125" type="text" name="vendor_code_value_product_stock_edit" id="vendor_code_value_product_stock_edit" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно "Изменить" -->