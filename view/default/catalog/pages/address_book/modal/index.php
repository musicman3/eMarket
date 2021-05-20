<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2 px-3">
                <h3 class="modal-title"><?php echo \eMarket\Core\Settings::titlePageGenerator() ?></h3>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <form id="form_add" class="was-validated" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">
                <div class="modal-body">
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />

                    <div class="mb-3">
                        <small class="form-text text-muted"><?php echo lang('address_book_country') ?></small>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bi-pencil"></span>
                            <select name="countries" id="countries" class="form-select">
                                <option value=""></option>
                            </select>
                        </div>

                        <small class="form-text text-muted"><?php echo lang('address_book_region') ?></small>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bi-pencil"></span>
                            <select name="regions" id="regions" class="form-select">
                                <option value=""></option>
                            </select>
                        </div>

                        <small class="form-text text-muted"><?php echo lang('address_book_city') ?></small>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bi-pencil"></span>
                            <input class="form-control" placeholder="<?php echo lang('address_book_city_placeholder') ?>" type="text" name="city"  id="city" required />
                        </div>

                        <small class="form-text text-muted"><?php echo lang('address_book_zip') ?></small>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bi-pencil"></span>
                            <input class="form-control" placeholder="<?php echo lang('address_book_zip_placeholder') ?>" type="text" name="zip"  id="zip" required />
                        </div>

                        <small class="form-text text-muted"><?php echo lang('address_book_shipping_address') ?></small>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bi-pencil"></span>
                            <input class="form-control" placeholder="<?php echo lang('address_book_address_placeholder') ?>" type="text" name="address"  id="address" required />
                        </div>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="default" id="default" checked>
                        <label class="form-check-label" for="default"><?php echo lang('default_set') ?> </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm bi-x-circle" type="button" data-bs-dismiss="modal"> <?php echo lang('cancel') ?></button>
                    <button class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>