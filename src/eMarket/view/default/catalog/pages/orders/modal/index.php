<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="index" class="products modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light py-2 px-3">
                <h3 class="modal-title" id="title"></h3>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#panel_edit_1"><?php echo lang('orders_description') ?></a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#panel_edit_2"><?php echo lang('orders_products') ?></a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#panel_edit_3"><?php echo lang('orders_transaction_history') ?></a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#panel_edit_4"><?php echo lang('orders_status_history') ?></a></li>
                </ul>

                <div class="tab-content pt-2">

                    <div id="panel_edit_1" class="tab-pane fade show active">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-start">
                                            <div class="badge bg-primary"><?php echo lang('orders_client') ?></div>
                                            <div>
                                                <small class="form-text text-muted">
                                                    <span class="bi-person"></span> <span id="description_client_name"></span><br>
                                                    <span class="bi-phone"></span> <span id="description_client_phone"></span><br>
                                                    <span class="bi-envelope"></span> <span id="description_client_email"></span>
                                                </small>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="badge bg-primary"><?php echo lang('orders_payment_method') ?></div>
                                            <div>
                                                <small class="form-text text-muted">
                                                    <span class="bi-credit-card"></span> <span id="description_payment_method"></span>
                                                </small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">
                                            <div class="badge bg-primary"><?php echo lang('orders_shipping') ?></div>
                                            <div>
                                                <small class="form-text text-muted">
                                                    <span class="bi-truck"></span> <span id="description_shipping_method"></span><br>
                                                    <span class="bi-globe"></span> <span id="description_shipping_country"></span><br>
                                                    <span class="bi-house-door"></span> <span id="description_shipping_address"></span>
                                                </small>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="badge bg-primary"><?php echo lang('orders_billing_address') ?></div>
                                            <div>
                                                <small class="form-text text-muted">
                                                    <span class="bi-globe"></span> <span id="description_billing_country"></span><br>
                                                    <span class="bi-house-door"></span> <span id="description_billing_address"></span>
                                                </small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">
                                            <div class="badge bg-primary"><?php echo lang('orders_status') ?></div>
                                            <div>
                                                <small class="form-text text-muted">
                                                    <span class="bi-clock"></span> <span id="description_date_purchased"></span><br>
                                                </small>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="badge bg-primary"><?php echo lang('orders_total') ?></div>
                                            <div>
                                                <small class="form-text text-muted">
                                                    <span class="bi-upc"></span> <span id="description_order_total"></span>
                                                </small>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="panel_edit_2" class="tab-pane fade show">
                        <div class="table-responsive">

                            <table class="table overflow-hidden rounded-top">
                                <thead>
                                    <tr class="bg-primary text-light align-middle">
                                        <td class="text-start"><small><?php echo lang('orders_sticker') ?></small></td>
                                        <td class="text-center"><small><?php echo lang('orders_product') ?></small></td>
                                        <td class="text-center"><small><?php echo lang('orders_price') ?></small></td>
                                        <td class="text-center"><small><?php echo lang('orders_quantity') ?></small></td>
                                        <td class="text-end"><small><?php echo lang('orders_amount') ?></small></td>
                                    </tr>
                                </thead>
                                <tbody id="invoice"></tbody>
                                <tbody>
                                    <tr class="align-middle">
                                        <td colspan="3" class="text-end"><small><?php echo lang('orders_subtotal') ?>:</small></td>
                                        <td colspan="2" class="text-end"><small id="invoice_order_total"></small></td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td  colspan="3" class="text-end"><small><?php echo lang('orders_estimated_taxes') ?></small></td>
                                        <td  colspan="2" class="text-end"><small id="invoice_taxes"></small></td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td colspan="3" class="text-end"><small class="badge bg-success" id="invoice_shipping_method"></small></td>
                                        <td colspan="2" class="text-end"><small id="invoice_shipping_price"></small></td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td colspan="3" class="text-end"><div class="badge bg-danger"><?php echo lang('orders_total') ?>:</div></td>
                                        <td colspan="2" class="text-end"><small class="badge bg-danger" id="invoice_order_total_to_pay"></small></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div id="panel_edit_3" class="tab-pane fade show">
                        <div class="mb-3">

                        </div>
                    </div>

                    <div id="panel_edit_4" class="tab-pane fade show">
                        <div class="mb-3">
                            <div id="status_history"></div><br>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>