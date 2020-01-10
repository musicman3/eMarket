<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Добавить" -->
<div id="add" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Сокращенное наименование указывается любыми символами" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Set::titlePageGenerator() ?></h4>
            </div>
            <form id="form_add_mod" name="form_add_mod" action="javascript:void(null);" onsubmit="callAdd('form_add_mod')">
                <div class="panel-body">
                    <input type="hidden" name="add" value="ok" />

                    <!-- Содержимое языковых панелей -->
                    <div class="tab-content">
                        <div class="form-group">
                            <label for="zone">Модуль доставки</label>
                            <div class="input-group">

                                <select id="example-buttonClass-buttonTitle-selectAllJustVisible-xss-html-collapseOptGroupsByDefault-buttonText-selectAllText-collapsedClickableOptGroups-includeSelectAllOption" multiple="multiple">
                                    <option value="free">Бесплатная доставка</option>
                                    <option value="robokassa">Robokassa</option>
                                </select>
                            </div>
                            <small id="zone_action" class="form-text text-muted">Выберите модуль доставки</small>
                        </div>
                        <div class="form-group">
                            <label for="order_status">Статус заказа</label>
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                                <select name="order_status" id="order_status" class="input-sm form-control">
                                    <option value="pending">Ожидает оплаты</option>
                                    <option value="payment">Оплачено</option>
                                </select>
                            </div>
                            <small id="zone_action" class="form-text text-muted">Выберите статус заказа</small>
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
<!-- КОНЕЦ Модальное окно "Добавить" -->