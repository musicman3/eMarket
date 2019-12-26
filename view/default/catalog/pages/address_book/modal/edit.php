<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Модальное окно "Изменить" -->
<div id="edit" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Сокращенное наименование указывается любыми символами" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Set::titlePageGenerator() ?></h4>
            </div>
            <form id="form_edit" name="form_edit" action="javascript:void(null);" onsubmit="callEdit()">
                <div class="panel-body">
                    <input id="js_edit" type="hidden" name="edit" value="" />

                    <div class="form-group">
                        <small class="form-text text-muted">Страна</small>
                        <div class="input-group has-success">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <select name="countries_edit" id="countries_edit" class="input-sm form-control">
                                    <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="form-text text-muted">Регион</small>
                        <div class="input-group has-success">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <select name="regions_edit" id="regions_edit" class="input-sm form-control">
                                    <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="form-text text-muted">Город</small>
                        <div class="input-group has-error">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <input class="input-sm form-control" placeholder="Введите название Вашего города" type="text" name="city_edit"  id="city_edit" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="form-text text-muted">Почтовый код</small>
                        <div class="input-group has-error">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <input class="input-sm form-control" placeholder="Введите почтовый код" type="text" name="zip_edit"  id="zip_edit" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="form-text text-muted">Адрес доставки</small>
                        <div class="input-group has-error">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <input class="input-sm form-control" placeholder="Введите адрес доставки" type="text" name="address_edit"  id="address_edit" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="check-box" hidden type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="default_edit" id="default_edit" checked>
                        <label for="default_edit"><?php echo lang('default_set') ?> </label>
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