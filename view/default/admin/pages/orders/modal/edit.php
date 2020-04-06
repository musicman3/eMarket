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
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-left">
                                            <div class="col-left form-group">
                                                <div class="label label-primary">Клиент</div>
                                                <div>
                                                    <small class="form-text text-muted">
                                                        <span class="glyphicon glyphicon-user"></span> Николай Пермяков<br>
                                                        <span class="glyphicon glyphicon-phone"></span> 9261234567<br>
                                                        <span class="glyphicon glyphicon-envelope"></span> user@oscommerce.ru
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            <div class="col-left form-group">
                                                <div class="label label-primary">Адрес доставки</div>
                                                <div>
                                                    <small class="form-text text-muted">
                                                        <span class="glyphicon glyphicon-globe"></span> Российская Федерация<br>
                                                        <span class="glyphicon glyphicon-home"></span> Москва, Симферопольский бульвар, дом 1
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class="col-left form-group">
                                                <div class="label label-primary">Платежный адрес</div>
                                                <div>
                                                    <small class="form-text text-muted">
                                                        <span class="glyphicon glyphicon-globe"></span> Российская Федерация<br>
                                                        <span class="glyphicon glyphicon-home"></span> Москва, Симферопольский бульвар, дом 1
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            <div class="col-left form-group">
                                                <div class="label label-primary">Метод оплаты</div>
                                                <div>
                                                    <small class="form-text text-muted">
                                                        <span class="glyphicon glyphicon-credit-card"></span> Наличными при получении
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class="col-left form-group">
                                                <div class="label label-primary">Итого</div>
                                                <div>
                                                    <small class="form-text text-muted">
                                                        <span class="glyphicon glyphicon-list-alt"></span> 12000 руб.
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            <div class="col-left form-group">
                                                <div class="label label-primary">Статус</div>
                                                <div>
                                                    <small class="form-text text-muted">
                                                        <span class="glyphicon glyphicon-time"></span> Оплачен: 22.08.2015 15:32:18<br>
                                                        <span class="glyphicon glyphicon-comment"></span> Комментарии: 0
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Содержимое панели Товары -->
                        <div id="panel_edit_2" class="tab-pane fade">
                            <div class="table-responsive">

                                <table class="table table-radius">
                                    <thead>
                                        <tr class="bg-primary">
                                            <td class="text-left"><small>Товар</small></td>
                                            <td class="text-center"><small>Цена</small></td>
                                            <td class="text-center"><small>Кол-во</small></td>
                                            <td class="text-right"><small>Сумма</small></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-success">
                                            <td class="text-left"><small>111</small></td>
                                            <td class="text-center"><small>222</small></td>
                                            <td class="text-center"><small>333</small></td>
                                            <td class="text-right"><small>444</small></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="text-right"><small>Стоимость:</small></td>
                                            <td class="text-right"><small>444</small></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><small>Доставка:</small></td>
                                            <td class="text-right"><small>444</small></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><div class="label label-danger">Итого:</div></td>
                                            <td class="text-right"><small class="label label-danger">444</small></td>
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