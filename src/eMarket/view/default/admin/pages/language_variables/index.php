<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages,
};
use eMarket\Admin\LanguageVariables;
?>

<div id="settings_vendor_codes">
    <div class="card">
        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
        </div>
        <form id="form_add" class="was-validated" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">
            <input type="hidden" id="edit" name="edit" value="ok" />
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="align-middle">
                                <th class="text-center"><?php echo lang('language_variables_admin') ?></th>
                                <th class="text-center"><?php echo lang('language_variables_catalog') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="align-middle">
                                <td class="text-center">
                                    <textarea class="form-control" name="admin_lang" id="admin_lang" rows="15"><?php echo LanguageVariables::adminLanguage() ?></textarea>
                                </td>
                                <td class="text-center">
                                    <textarea class="form-control" name="catalog_lang" id="catalog_lang" rows="15"><?php echo LanguageVariables::catalogLanguage() ?></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="mb-3 text-center">
                <button class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button>
            </div>
        </form>
    </div>
</div>
