<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Добавить" -->
<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Сокращенное наименование указывается любыми символами" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Set::titlePageGenerator() ?></h4>
            </div>
            <form id="form_add" name="form_add" action="javascript:void(null);" onsubmit="callAdd()">
                <div class="panel-body">
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />

                    <div class="form-group">
                        <small class="form-text text-muted"><?php echo lang('address_book_country') ?></small>
                        <div class="input-group has-success">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <select name="countries" id="countries" class="input-sm form-control">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="form-text text-muted"><?php echo lang('address_book_region') ?></small>
                        <div class="input-group has-success">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <select name="regions" id="regions" class="input-sm form-control">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="form-text text-muted"><?php echo lang('address_book_city') ?></small>
                        <div class="input-group has-error">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <input class="input-sm form-control" placeholder="<?php echo lang('address_book_city_placeholder') ?>" type="text" name="city"  id="city" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="form-text text-muted"><?php echo lang('address_book_zip') ?></small>
                        <div class="input-group has-error">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <input class="input-sm form-control" placeholder="<?php echo lang('address_book_zip_placeholder') ?>" type="text" name="zip"  id="zip" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="form-text text-muted"><?php echo lang('address_book_shipping_address') ?></small>
                        <div class="input-group has-error">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <input class="input-sm form-control" placeholder="<?php echo lang('address_book_address_placeholder') ?>" type="text" name="address"  id="address" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="check-box" hidden type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="default" id="default" checked>
                        <label for="default"><?php echo lang('default_set') ?> </label>
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