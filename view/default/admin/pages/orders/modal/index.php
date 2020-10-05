<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Модальное окно "Изменить" -->
<div id="index" class="products modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title" id="title"></h4>
            </div>
            <form id="form_add" name="form_add" action="javascript:void(null);" onsubmit="callAdd()">
                <div class="panel-body">
                    <input type="hidden" id="edit" name="edit" value="" />
                    <!-- Панели формы -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#panel_1"><?php echo lang('orders_description') ?></a></li>
                        <li><a data-toggle="tab" href="#panel_2"><?php echo lang('orders_products') ?></a></li>
                        <li><a data-toggle="tab" href="#panel_3"><?php echo lang('orders_transaction_history') ?></a></li>
                        <li><a data-toggle="tab" href="#panel_4"><?php echo lang('orders_status_history') ?></a></li>
                    </ul>
                    <!-- Содержимое панелей формы-->
                    <div class="tab-content">

                        <!-- Содержимое панели Описание -->
                        <div id="panel_1" class="tab-pane fade in active">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="text-left">
                                                <div class="label label-primary"><?php echo lang('orders_client') ?></div>
                                                <div>
                                                    <small class="form-text text-muted">
                                                        <span class="glyphicon glyphicon-user"></span> <span id="description_client_name"></span><br>
                                                        <span class="glyphicon glyphicon-phone"></span> <span id="description_client_phone"></span><br>
                                                        <span class="glyphicon glyphicon-envelope"></span> <span id="description_client_email"></span>
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                <div class="label label-primary"><?php echo lang('orders_payment_method') ?></div>
                                                <div>
                                                    <small class="form-text text-muted">
                                                        <span class="glyphicon glyphicon-credit-card"></span> <span id="description_payment_method"></span>
                                                    </small>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">
                                                <div class="label label-primary"><?php echo lang('orders_shipping') ?></div>
                                                <div>
                                                    <small class="form-text text-muted">
                                                        <span class="glyphicon glyphicon-plane"></span> <span class="label label-success" id="description_shipping_method"></span><br>
                                                        <span class="glyphicon glyphicon-globe"></span> <span id="description_shipping_country"></span><br>
                                                        <span class="glyphicon glyphicon-home"></span> <span id="description_shipping_address"></span>
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                <div class="label label-primary"><?php echo lang('orders_billing_address') ?></div>
                                                <div>
                                                    <small class="form-text text-muted">
                                                        <span class="glyphicon glyphicon-globe"></span> <span id="description_billing_country"></span><br>
                                                        <span class="glyphicon glyphicon-home"></span> <span id="description_billing_address"></span>
                                                    </small>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">
                                                <div class="label label-primary"><?php echo lang('orders_status') ?></div>
                                                <div>
                                                    <small class="form-text text-muted">
                                                        <span class="glyphicon glyphicon-time"></span> <span id="description_date_purchased"></span><br>
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                <div class="label label-primary"><?php echo lang('orders_total') ?></div>
                                                <div>
                                                    <small class="form-text text-muted">
                                                        <span class="glyphicon glyphicon-barcode"></span> <span id="description_order_total"></span>
                                                    </small>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Содержимое панели Товары -->
                        <div id="panel_2" class="tab-pane fade">
                            <div class="table-responsive">

                                <table class="table table-radius">
                                    <thead>
                                        <tr class="bg-primary">
                                            <td class="text-left"><small><?php echo lang('orders_product') ?></small></td>
                                            <td class="text-center"><small><?php echo lang('orders_price') ?></small></td>
                                            <td class="text-center"><small><?php echo lang('orders_quantity') ?></small></td>
                                            <td class="text-right"><small><?php echo lang('orders_amount') ?></small></td>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice"></tbody>
                                </table>

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="text-right"><small><?php echo lang('orders_subtotal') ?>:</small></td>
                                            <td class="text-right"><small id="invoice_order_total"></small></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><small class="label label-success" id="invoice_shipping_method"></small></td>
                                            <td class="text-right"><small id="invoice_shipping_price"></small></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><div class="label label-danger"><?php echo lang('orders_total') ?>:</div></td>
                                            <td class="text-right"><small class="label label-danger" id="invoice_order_total_with_shipping"></small></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <!-- Содержимое панели История транзакций -->
                        <div id="panel_3" class="tab-pane fade">
                            <div class="col-left form-group">

                            </div>
                        </div>

                        <!-- Содержимое панели История статусов -->
                        <div id="panel_4" class="tab-pane fade">
                            <div class="form-group">
                                <div class="input-group has-success" id="status_history"></div><br>
                                <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                                <select name="status_history_select" id="status_history_select" class="input-sm form-control">
                                    <?php foreach ($order_status as $value) { ?>
                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                    <?php } ?>
                                </select>
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